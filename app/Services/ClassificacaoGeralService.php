<?php

namespace App\Services;

use App\Repositories\Eloquent\ClassificacaoGeralRepository;
use App\Repositories\Eloquent\ProvaRepository;
use App\Repositories\Eloquent\ResultadoRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ClassificacaoGeralService
{

    private $repository;

    public function __construct()
    {
        $this->repository = new ClassificacaoGeralRepository();
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

    public function gerarClassificacao(int $idProva): bool
    {
        $this->repository->limparClassificacoesPorProva($idProva);

        $listaDeResultadosCorredores = (new ResultadoRepository())->consultaResultadoGeral($idProva);

        return $this->salvarPosicoes($listaDeResultadosCorredores);
    }

    private function salvarPosicoes(Collection $listaDeResultadosCorredores): bool
    {
        $posicao = 1;

        foreach ($listaDeResultadosCorredores as $resultado) {
            $this->repository->create([
                'posicao' => $posicao,
                'corredor_id' => $resultado->corredor_id,
                'prova_id' => $resultado->prova_id,
            ]);

            $posicao++;
        }

        return true;
    }
}
