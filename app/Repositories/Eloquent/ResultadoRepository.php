<?php

namespace App\Repositories\Eloquent;

use App\Models\Resultado;
use App\Repositories\Contracts\ResultadoRepositoryInterface;

class ResultadoRepository extends AbstractRepository implements ResultadoRepositoryInterface
{
    protected $model = Resultado::class;
}
