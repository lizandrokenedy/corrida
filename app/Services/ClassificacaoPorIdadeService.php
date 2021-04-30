<?php

namespace App\Services;

use App\Repositories\Eloquent\ClassificacaoPorIdadeRepository;
use App\Repositories\Eloquent\ResultadoRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ClassificacaoPorIdadeService
{

    private $repository;

    public function __construct()
    {
        $this->repository = new ClassificacaoPorIdadeRepository();
    }


    public function listar()
    {
        return $this->repository->all();
    }


    public function criar(array $dados = []): bool
    {
        return $this->repository->create($dados);
    }

    public function obterPorId(int $id)
    {
        return $this->repository->find($id);
    }

    public function atualizar(array $dados = [], int $id): bool
    {

        $registro = $this->repository->update($dados, $id);

        if (!$registro) {
            throw new Exception('Registro não encontrado.');
        }

        return $registro;
    }

    public function deletar(int $id): bool
    {
        $registro = $this->repository->delete($id);

        if (!$registro) {
            throw new Exception('Registro não encontrado.');
        }

        return $registro;
    }

    private function salvarPosicoes(Collection $listaDeResultadosCorredores): bool
    {
        $posicao = 1;

        foreach ($listaDeResultadosCorredores as $resultado) {
            $this->repository->create([
                'idade' => $resultado->idade,
                'posicao' => $posicao,
                'corredor_id' => $resultado->corredor_id,
                'prova_id' => $resultado->prova_id,
            ]);

            $posicao++;
        }

        return true;
    }

    public function gerarClassificacao(int $idProva): bool
    {
        $this->repository->limparClassificacoesPorProva($idProva);

        $this->gerarClassificacao18a25Anos($idProva);
        $this->gerarClassificacao26a35Anos($idProva);
        $this->gerarClassificacao36a45Anos($idProva);
        $this->gerarClassificacao46a55Anos($idProva);
        $this->gerarClassificacaoAcimaDos56Anos($idProva);

        return true;
    }

    public function gerarClassificacao18a25Anos(int $idProva): bool
    {
        $resultado = (new ResultadoRepository())->consultaResultadoPorFaixaDeIdade($idProva, 18, 25);

        return $this->salvarPosicoes($resultado);
    }

    public function gerarClassificacao26a35Anos(int $idProva): bool
    {
        $resultado = (new ResultadoRepository())->consultaResultadoPorFaixaDeIdade($idProva, 26, 35);

        return $this->salvarPosicoes($resultado);
    }

    public function gerarClassificacao36a45Anos($idProva): bool
    {
        $resultado = (new ResultadoRepository())->consultaResultadoPorFaixaDeIdade($idProva, 36, 45);

        return $this->salvarPosicoes($resultado);
    }

    public function gerarClassificacao46a55Anos($idProva): bool
    {
        $resultado = (new ResultadoRepository())->consultaResultadoPorFaixaDeIdade($idProva, 46, 55);

        return $this->salvarPosicoes($resultado);
    }

    public function gerarClassificacaoAcimaDos56Anos($idProva): bool
    {
        $resultado = (new ResultadoRepository())->consultaResultadoPorFaixaDeIdade($idProva, 56);

        return $this->salvarPosicoes($resultado);
    }
}
