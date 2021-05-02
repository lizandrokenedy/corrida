<?php

namespace App\Services;

use App\Repositories\Eloquent\CorredorEmProvaRepository;
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

        if ($this->validaSeCorredorEstaCadastradoParaAlgumaProva($id)) {
            throw new Exception('Não é possível excluir o corredor, pois o mesmo possui cadastro para uma ou mais provas');
        }

        $registro = $this->repository->delete($id);

        if (!$registro) {
            throw new Exception('Registro não encontrado.');
        }

        return $registro;
    }

    /**
     * Valida se o corredor está cadastrado para alguma prova
     *
     * @param integer $idCorredor
     * @return boolean
     */
    private function validaSeCorredorEstaCadastradoParaAlgumaProva(int $idCorredor): bool
    {
        return (new CorredorEmProvaRepository())->consultaProvasDoCorredor($idCorredor)->count() > 0 ? true : false;
    }
}
