<?php

namespace App\Services;

use App\Repositories\Eloquent\TipoClassificacaoRepository;
use Exception;

class TipoClassificacaoService
{

    private $repository;

    public function __construct()
    {
        $this->repository = new TipoClassificacaoRepository();
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
}
