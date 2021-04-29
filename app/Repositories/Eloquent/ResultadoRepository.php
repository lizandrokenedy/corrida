<?php

namespace App\Repositories\Eloquent;

use App\Models\Resultado;
use App\Repositories\Contracts\ResultadoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ResultadoRepository extends AbstractRepository implements ResultadoRepositoryInterface
{
    protected $model = Resultado::class;

    public function consultaResultadoProvaCorredor(int $idProva, int $idCorredor): Collection
    {
        return $this->model::where('prova_id', $idProva)
            ->where('corredor_id', $idCorredor)
            ->get();
    }

    public function listaDeResultadosPorProva(int $idProva): Collection
    {
        return $this->model::where('prova_id', $idProva)
            ->orderBy('conclusao_prova', 'asc')
            ->get();
    }
}
