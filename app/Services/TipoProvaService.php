<?php

namespace App\Services;

use App\Repositories\Eloquent\TipoProvaRepository;
use Exception;

class TipoProvaService
{

    private $repository;

    public function __construct()
    {
        $this->repository = new TipoProvaRepository();
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
     * Obtem um registro por id
     *
     * @param integer $id
     * @return void
     */
    public function obterPorId(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * Atualiza um registro
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
     * Deleta um registro
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
