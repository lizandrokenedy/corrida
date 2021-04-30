<?php

namespace App\Repositories\Eloquent;

use App\Models\Resultado;
use App\Repositories\Contracts\ResultadoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ResultadoRepository extends AbstractRepository implements ResultadoRepositoryInterface
{
    protected $model = Resultado::class;

    public function consultaResultadoProvaCorredor(int $idProva, int $idCorredor): Collection
    {
        return $this->model::where('prova_id', $idProva)
            ->where('corredor_id', $idCorredor)
            ->get();
    }

    public function consultaResultadoGeral(int $idProva): Collection
    {
        return $this->model::where('prova_id', $idProva)
            ->orderBy('conclusao_prova', 'asc')
            ->get();
    }


    public function consultaResultadoPorFaixaDeIdade(int $idProva, int $faixaInicial, int $faixaFinal = 0): Collection
    {
        return $this->model::selectRaw('
            corredor_id,
            prova_id,
            YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(data_nascimento))) as idade'
        )
            ->join('corredores', 'corredores.id', 'resultados.corredor_id')
            ->where('prova_id', $idProva)
            ->where(function ($query) use ($faixaInicial, $faixaFinal) {
                if ($faixaInicial !== 0 && $faixaFinal !== 0) {
                    $query->whereRaw('YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(data_nascimento))) between ? AND ?', [$faixaInicial, $faixaFinal]);
                }

                if ($faixaFinal === 0) {
                    $query->whereRaw('YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(data_nascimento))) >= ?', [$faixaInicial]);
                }
            })
            ->orderBy('conclusao_prova', 'asc')
            ->get();
    }
}
