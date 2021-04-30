<?php

namespace App\Repositories\Eloquent;

use App\Models\CorredorEmProva;
use App\Repositories\Contracts\CorredorEmProvaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CorredorEmProvaRepository extends AbstractRepository implements CorredorEmProvaRepositoryInterface
{
    protected $model = CorredorEmProva::class;

    /**
     * Consulta todas as provas do corredor
     *
     * @param integer $idCorredor
     * @return Collection
     */
    public function consultaProvasDoCorredor(int $idCorredor): Collection
    {
        return $this->model::join('corredores', 'corredores.id', 'corredores_em_provas.corredor_id')
            ->join('provas', 'provas.id', 'corredores_em_provas.prova_id')
            ->where('corredores.id', $idCorredor)
            ->get();
    }

    /**
     * Consulta uma prova do corredor
     *
     * @param integer $idProva
     * @param integer $idCorredor
     * @return Collection
     */
    public function consultaProvaDoCorredor(int $idProva, int $idCorredor): Collection
    {
        return $this->model::where('corredor_id', $idCorredor)
            ->where('prova_id', $idProva)
            ->get();
    }
}
