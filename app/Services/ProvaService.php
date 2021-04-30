<?php

namespace App\Services;

use App\Repositories\Eloquent\ProvaRepository;
use Exception;

class ProvaService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new ProvaRepository();
    }


    public function listar()
    {
        return $this->repository->all();
    }

    /**
     * Cria um registro de prova
     *
     * @param array $dados
     * @return boolean
     */
    public function criar(array $dados = []): bool
    {
        return $this->repository->create($dados);
    }

    /**
     * Obtem uma prova por id
     *
     * @param integer $id
     * @return void
     */
    public function obterPorId(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Atualiza um registro de prova
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
     * Deleta um registro de prova
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
