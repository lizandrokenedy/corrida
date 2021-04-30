<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassificacaoPorIdade;
use App\Repositories\Contracts\ClassificacaoPorIdadeRepositoryInterface;

class ClassificacaoPorIdadeRepository extends AbstractRepository implements ClassificacaoPorIdadeRepositoryInterface
{
    protected $model = ClassificacaoPorIdade::class;


    public function limparClassificacoesPorProva(int $idProva): bool
    {
        return $this->model::where('prova_id', $idProva)->delete();
    }
}
