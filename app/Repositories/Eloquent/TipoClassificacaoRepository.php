<?php

namespace App\Repositories\Eloquent;

use App\Models\TipoClassificacao;
use App\Repositories\Contracts\TipoClassificacaoRepositoryInterface;

class TipoClassificacaoRepository extends AbstractRepository implements TipoClassificacaoRepositoryInterface
{
    protected $model = TipoClassificacao::class;
}
