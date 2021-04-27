<?php

namespace App\Repositories\Eloquent;

use App\Models\Corredor;
use App\Repositories\Contracts\CorredorRepositoryInterface;

class CorredorRepository extends AbstractRepository implements CorredorRepositoryInterface
{
    protected $model = Corredor::class;
}
