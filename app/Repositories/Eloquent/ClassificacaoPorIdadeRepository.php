<?php

namespace App\Repositories\Eloquent;

use App\Models\ClassificacaoPorIdade;
use App\Repositories\Contracts\ClassificacaoPorIdadeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ClassificacaoPorIdadeRepository extends AbstractRepository implements ClassificacaoPorIdadeRepositoryInterface
{
    protected $model = ClassificacaoPorIdade::class;


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
     * Consulta classificação por idade
     *
     * @return Collection
     */
    public function consultaClassificacaoPorIdade(): Collection
    {
        return $this->model::selectRaw('
            CASE
                WHEN idade >= 18 and idade <= 25 THEN "18 – 25 anos"
                WHEN idade >= 26 and idade <= 35 THEN "26 – 35 anos"
                WHEN idade >= 36 and idade <= 45 THEN "36 – 45 anos"
                WHEN idade >= 46 and idade <= 55 THEN "46 – 55 anos"
                ELSE "Acima de 56 anos"
                END AS faixa,
            nome,
            idade,
            posicao,
            descricao,
            cpf,
            data_nascimento
            ')
            ->join('corredores', 'corredores.id', 'classificacao_por_idade.corredor_id')
            ->join('tipos_provas', 'tipos_provas.id', 'classificacao_por_idade.prova_id')
            ->get();
    }
}
