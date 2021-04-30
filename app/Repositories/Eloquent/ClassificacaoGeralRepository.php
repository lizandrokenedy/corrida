<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassificacaoGeral;
use App\Repositories\Contracts\ClassificacaoGeralRepositoryInterface;

class ClassificacaoGeralRepository extends AbstractRepository implements ClassificacaoGeralRepositoryInterface
{
    protected $model = ClassificacaoGeral::class;

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
