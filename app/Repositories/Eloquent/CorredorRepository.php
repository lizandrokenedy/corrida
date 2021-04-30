<?php

namespace App\Repositories\Eloquent;

use App\Models\Corredor;
use App\Repositories\Contracts\CorredorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CorredorRepository extends AbstractRepository implements CorredorRepositoryInterface
{
    protected $model = Corredor::class;
}
