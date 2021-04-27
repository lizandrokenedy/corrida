<?php

namespace App\Repositories\Eloquent;

use App\Models\Prova;
use App\Repositories\Contracts\ProvaRepositoryInterface;

class ProvaRepository extends AbstractRepository implements ProvaRepositoryInterface
{
    protected $model = Prova::class;
}
