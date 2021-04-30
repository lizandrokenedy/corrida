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

    /**
     * Cria um registro
     *
     * @param array $dados
     * @return boolean
     */
    public function criar(array $dados = []): bool
    {
        return $this->repository->create($dados);
    }

    /**
     * Deleta um registro por id
     *
     * @param integer $id
     * @return boolean
     */
    public function deletar(int $id): bool
    {
        $registro = $this->repository->delete($id);

        if (!$registro) {
            throw new Exception('Registro não encontrado.');
        }

        return $registro;
    }

    /**
     * Gera e salva as posições dos corredores
     *
     * @param Collection $listaDeResultadosCorredores
     * @return boolean
     */
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

    /**
     * Gera classificações por idade de uma prova
     *
     * @param integer $idProva
     * @return boolean
     */
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

    /**
     * Gera classificações dos 18 aos 25 anos de uma prova
     *
     * @param integer $idProva
     * @return boolean
     */
    public function gerarClassificacao18a25Anos(int $idProva): bool
    {
        $resultado = (new ResultadoRepository())->consultaResultadoPorFaixaDeIdade($idProva, 18, 25);

        return $this->salvarPosicoes($resultado);
    }

    /**
     * Gera classificações dos 26 aos 35 anos de uma prova
     *
     * @param integer $idProva
     * @return boolean
     */
    public function gerarClassificacao26a35Anos(int $idProva): bool
    {
        $resultado = (new ResultadoRepository())->consultaResultadoPorFaixaDeIdade($idProva, 26, 35);

        return $this->salvarPosicoes($resultado);
    }

    /**
     * Gera classificações dos 36 aos 45 anos de uma prova
     *
     * @param integer $idProva
     * @return boolean
     */
    public function gerarClassificacao36a45Anos(int $idProva): bool
    {
        $resultado = (new ResultadoRepository())->consultaResultadoPorFaixaDeIdade($idProva, 36, 45);

        return $this->salvarPosicoes($resultado);
    }

    /**
     * Gera classificações dos 46 aos 55 anos de uma prova
     *
     * @param integer $idProva
     * @return boolean
     */
    public function gerarClassificacao46a55Anos(int $idProva): bool
    {
        $resultado = (new ResultadoRepository())->consultaResultadoPorFaixaDeIdade($idProva, 46, 55);

        return $this->salvarPosicoes($resultado);
    }

    /**
     * Gera classificações acima dos 56 anos de uma prova
     *
     * @param integer $idProva
     * @return boolean
     */
    public function gerarClassificacaoAcimaDos56Anos(int $idProva): bool
    {
        $resultado = (new ResultadoRepository())->consultaResultadoPorFaixaDeIdade($idProva, 56);

        return $this->salvarPosicoes($resultado);
    }
}
