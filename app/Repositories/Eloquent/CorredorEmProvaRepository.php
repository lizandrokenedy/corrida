<?php

namespace App\Repositories\Eloquent;

use App\Models\CorredorEmProva;
use App\Repositories\Contracts\CorredorRepositoryInterface;

class CorredorEmProvaRepository extends AbstractRepository implements CorredorRepositoryInterface
{
    protected $model = CorredorEmProva::class;
}
