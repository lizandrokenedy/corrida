<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassificacaoPorIdade;
use App\Repositories\Contracts\ClassificacaoPorIdadeRepositoryInterface;

class ClassificacaoPorIdadeRepository extends AbstractRepository implements ClassificacaoPorIdadeRepositoryInterface
{
    protected $model = ClassificacaoPorIdade::class;


    public function consultaClassificacoes()
    {
        // $this->model::with('provas')
        // ->where('tipo_prova_id')
    }
}
