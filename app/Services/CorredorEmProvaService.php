<?php

namespace App\Services;

use App\Repositories\Eloquent\CorredorEmProvaRepository;
use App\Repositories\Eloquent\ProvaRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class CorredorEmProvaService
{

    private $repository;

    public function __construct()
    {
        $this->repository = new CorredorEmProvaRepository();
        $this->repositoryProva = new ProvaRepository();
    }

    public function listar(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Adiciona o corredor a uma prova
     *
     * @param array $dados
     * @return boolean
     */
    public function criar(array $dados = []): bool
    {
        $corredorCadastradoEmProvaParaMesmaData = $this->validaCorredorCadastradoEmProvaParaMesmaData($dados['corredor_id'], $dados['prova_id']);
        if ($corredorCadastradoEmProvaParaMesmaData) {
            throw new Exception('Corredor já possui uma prova para esta data.');
        }

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
     * Checa se o corredor já possui uma prova para o mesmo dia
     *
     * @param integer $idCorredor
     * @param integer $idProva
     * @return boolean
     */
    private function validaCorredorCadastradoEmProvaParaMesmaData(int $idCorredor, int $idProva): bool
    {
        $provasDoCorredor = $this->repository->consultaProvasDoCorredor($idCorredor);
        if ($provasDoCorredor) {
            $prova = $this->repositoryProva->find($idProva);

            foreach ($provasDoCorredor as $provaDoCorredor) {
                $dataProvaCadastrada = Carbon::parse($provaDoCorredor->data)->format('Y-m-d');
                $dataNovaProva = Carbon::parse($prova->data)->format('Y-m-d');

                if ($dataNovaProva === $dataProvaCadastrada) {
                    return true;
                }
            }
        }

        return false;
    }
}
