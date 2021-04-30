<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassificacaoPorIdade;
use App\Repositories\Contracts\ClassificacaoPorIdadeRepositoryInterface;

class ClassificacaoPorIdadeRepository extends AbstractRepository implements ClassificacaoPorIdadeRepositoryInterface
{
    protected $model = ClassificacaoPorIdade::class;


    /**
     * Limpa as classificações de uma prova
     *
     * @param integer $idProva
     * @return boolean
     */
    public function limparClassificacoesPorProva(int $idProva): bool
    {
        return $this->model::where('prova_id', $idProva)->delete();
    }
}
