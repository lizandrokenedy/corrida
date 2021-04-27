<?php

namespace App\Repositories\Eloquent;

use App\Models\TipoProva;
use App\Repositories\Contracts\TipoProvaRepositoryInterface;

class TipoProvaRepository extends AbstractRepository implements TipoProvaRepositoryInterface
{
    protected $model = TipoProva::class;
}
