<?php

namespace App\Repositories\Eloquent;

use App\Models\Prova;
use App\Repositories\Contracts\ProvaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProvaRepository extends AbstractRepository implements ProvaRepositoryInterface
{
    protected $model = Prova::class;

    public function consultaProvasPorTipo(int $idTipoProva): Collection
    {
        return $this->model::where('tipo_prova_id', $idTipoProva)->get();
    }
}
