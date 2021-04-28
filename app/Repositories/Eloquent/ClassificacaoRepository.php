<?php

namespace App\Repositories\Eloquent;

use App\Models\Classificacao;
use App\Repositories\Contracts\ClassificacaoRepositoryInterface;

class ClassificacaoRepository extends AbstractRepository implements ClassificacaoRepositoryInterface
{
    protected $model = Classificacao::class;


    public function consultaClassificacoesGerais()
    {
        // $this->model::with('provas')
        // ->where('tipo_prova_id')
    }
}
