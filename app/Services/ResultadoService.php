<?php

namespace App\Services;

use App\Repositories\Eloquent\CorredorEmProvaRepository;
use App\Repositories\Eloquent\ProvaRepository;
use App\Repositories\Eloquent\ResultadoRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ResultadoService
{

    private $repository;

    public function __construct()
    {
        $this->repository = new ResultadoRepository();
    }

    /**
     * Lista resultados
     *
     * @return Collection
     */
    public function listar(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Função que cria um resultado de prova
     *
     * @param array $dados
     * @return boolean
     */
    public function criar(array $dados = []): bool
    {

        $this->aplicaRegrasParaGerarResultado($dados);

        return $this->repository->create($dados);
    }

    /**
     * Consulta lista de resultados ordenados por conclusao prova
     *
     * @param integer $idProva
     * @return Collection
     */
    public function resultadosPorProva(int $idProva): Collection
    {
        return $this->repository->consultaResultadoGeral($idProva);
    }

    /**
     * Função que aplica as regras para criação/atualização de um resultado de prova
     *
     * @param array $dados
     * @return void
     */
    private function aplicaRegrasParaGerarResultado(array $dados): void
    {
        if ($this->validaCorredorSemCadastroParaProva($dados['prova_id'], $dados['corredor_id'])) {
            throw new Exception('O corredor não está cadastrado para esta prova.');
        }

        if ($this->validaProvaConcluidaCorredor($dados['prova_id'], $dados['corredor_id'])) {
            throw new Exception('O corredor já possui resultado para esta prova.');
        }

        if ($this->validaInicioMaiorOuIgualConclusao($dados['inicio_prova'], $dados['conclusao_prova'])) {
            throw new Exception('O inicio resultado não pode ser maior ou igual a conclusão');
        }

        if ($this->validaInicioResultadoMenorQueInicioDaProva($dados['inicio_prova'], $dados['prova_id'])) {
            throw new Exception('O início resultado não poder ser menor ou igual ao início da prova');
        }
    }

    /**
     * Obtem um resultado por ID
     *
     * @param integer $id
     * @return Collection
     */
    public function obterPorId(int $id): Collection
    {
        return $this->repository->find($id);
    }

    /**
     * Função que valida se o corredor está cadastrado na prova para gerar resultado
     *
     * @param integer $idProva
     * @param integer $idCorredor
     * @return boolean
     */
    private function validaCorredorSemCadastroParaProva(int $idProva, int $idCorredor): bool
    {
        return (int)(new CorredorEmProvaRepository())->consultaProvaDoCorredor($idProva, $idCorredor)->count() === 0 ? true : false;
    }


    /**
     * Valida se o corredor já concluiu a prova
     *
     * @param integer $idProva
     * @param integer $idCorredor
     * @return boolean
     */
    private function validaProvaConcluidaCorredor(int $idProva, int $idCorredor): bool
    {
        return $this->repository->consultaResultadoProvaCorredor($idProva, $idCorredor)->count() > 0 ? true : false;
    }


    /**
     * Valida se a data início é maior ou igual a data fim
     *
     * @param [type] $inicioProva
     * @param [type] $conclusaoProva
     * @return boolean
     */
    private function validaInicioMaiorOuIgualConclusao($inicioProva, $conclusaoProva): bool
    {
        $inicio = Carbon::parse($inicioProva);
        $conclusao = Carbon::parse($conclusaoProva);

        if ($inicio >= $conclusao) {
            return true;
        }

        return false;
    }


    /**
     * Função que valida o resultado início menor que o início da prova
     *
     * @param string $inicioResultado
     * @param integer $idProva
     * @return boolean
     */
    private function validaInicioResultadoMenorQueInicioDaProva(string $inicioResultado, int $idProva): bool
    {
        $prova = Carbon::parse((new ProvaRepository)->find($idProva)->data);
        $resultado = Carbon::parse($inicioResultado);

        if ($resultado <= $prova) {
            return true;
        }

        return false;
    }
}
