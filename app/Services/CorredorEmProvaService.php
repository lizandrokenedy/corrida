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


    public function criar(array $dados = []): bool
    {
        $corredorCadastradoEmProvaParaMesmaData = $this->validaCorredorCadastradoEmProvaParaMesmaData($dados['corredor_id'], $dados['prova_id']);
        if ($corredorCadastradoEmProvaParaMesmaData) {
            throw new Exception('Corredor já possui uma prova para esta data.');
        }

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
