<?php

namespace App\Repositories\Eloquent;

use App\Models\CorredorEmProva;
use App\Repositories\Contracts\CorredorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CorredorEmProvaRepository extends AbstractRepository implements CorredorRepositoryInterface
{
    protected $model = CorredorEmProva::class;


    public function consultaProvasDoCorredor($idCorredor): Collection
    {
        return $this->model::join('corredores', 'corredores.id', 'corredores_em_provas.corredor_id')
            ->join('provas', 'provas.id', 'corredores_em_provas.prova_id')
            ->where('corredores.id', $idCorredor)
            ->get();
    }
}
