<?php

namespace Database\Seeders;

use App\Models\TipoClassificacao;
use Illuminate\Database\Seeder;

class TipoClassificacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposClassificacoes = [
            'Provas por Idade',
            'Provas Gerais',
        ];

        foreach ($tiposClassificacoes as $tipo) {
            TipoClassificacao::create([
                'descricao' => $tipo
            ]);
        }
    }
}
