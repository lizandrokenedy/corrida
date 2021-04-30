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

    /**
     * Cria um registro de corredor
     *
     * @param array $dados
     * @return boolean
     */
    public function criar(array $dados = []): bool
    {
        return $this->repository->create($dados);
    }

    /**
     * Obtem um corredor por id
     *
     * @param integer $id
     * @return void
     */
    public function obterPorId(int $id)
    {
        return $this->repository->find($id);
    }


    /**
     * Atualiza um registro de corredor
     *
     * @param array $dados
     * @param integer $id
     * @return boolean
     */
    public function atualizar(array $dados = [], int $id): bool
    {

        $registro = $this->repository->update($dados, $id);

        if (!$registro) {
            throw new Exception('Registro não encontrado.');
        }

        return $registro;
    }

    /**
     * Deleta um registro de corredor
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
}
