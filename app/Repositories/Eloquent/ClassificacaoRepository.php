<?php

namespace App\Repositories\Eloquent;

use App\Models\Classificacao;
use App\Repositories\Contracts\ClassificacaoRepositoryInterface;

class ClassificacaoRepository extends AbstractRepository implements ClassificacaoRepositoryInterface
{
    protected $model = Classificacao::class;
}
