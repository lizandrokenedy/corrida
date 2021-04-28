<?php

namespace App\Services;

use App\Repositories\Eloquent\CorredorRepository;
use Exception;

class CorredorService
{

    private $repository;

    public function __construct()
    {
        $this->repository = new CorredorRepository();
    }


    public function listar()
    {
        return $this->repository->all();
    }


    public function criar(array $dados = []): bool
    {
        $corredorMenorDeIdade = $this->validaCorredorMenorDeIdade($dados['idade']);

        if ($corredorMenorDeIdade) {
            throw new Exception('Não é permitido o cadastro de menores de idade,');
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

    private function validaCorredorMenorDeIdade(int $idade): bool
    {
        if ($idade < 18) {
            return true;
        }

        return false;
    }
}
