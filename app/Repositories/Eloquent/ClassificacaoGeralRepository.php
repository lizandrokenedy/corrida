<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassificacaoGeral;
use App\Repositories\Contracts\ClassificacaoGeralRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ClassificacaoGeralRepository extends AbstractRepository implements ClassificacaoGeralRepositoryInterface
{
    protected $model = ClassificacaoGeral::class;

    /**
     * Limpa as classificações de uma prova
     *
     * @param integer $idProva
     * @return boolean
     */
    public function limparClassificacoesPorProva(int $idProva): bool
    {
        return $this->model::where('prova_id', $idProva)->delete();
    }

    /**
     * Consulta classificação geral
     *
     * @return Collection
     */
    public function consultaClassificacaoGeral(): Collection
    {
        return $this->model::select(
            'nome',
            'posicao',
            'descricao',
            'cpf',
            'data_nascimento'
        )
        ->join('corredores', 'corredores.id', 'classificacao_geral.corredor_id')
        ->join('tipos_provas', 'tipos_provas.id', 'classificacao_geral.prova_id')
        ->get();
    }
}
