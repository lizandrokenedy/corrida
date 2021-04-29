<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassificacaoGeral;
use App\Repositories\Contracts\ClassificacaoGeralRepositoryInterface;

class ClassificacaoGeralRepository extends AbstractRepository implements ClassificacaoGeralRepositoryInterface
{
    protected $model = ClassificacaoGeral::class;


    public function consultaUltimaPosicaoInseridaPorProva(int $idProva): int
    {
        $resultado = $this->model::join('resultados', 'resultados.prova_id', 'classificacao_geral.prova_id')
            ->where('prova_id', $idProva)
            ->orderBy(['resultados.conclusao_prova', 'desc'], ['posicao', 'desc'])
            ->first('posicao');

        return $resultado ? $resultado->posicao + 1 : 1;
    }


    public function limparClassificacoesPorProva(int $idProva): bool
    {
        return $this->model::where('prova_id', $idProva)->delete();
    }
}
