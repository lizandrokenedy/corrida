<?php

namespace Database\Seeders;

use App\Models\TipoProva;
use Illuminate\Database\Seeder;

class TipoProvaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposProvas = [
            '3 km',
            '5 km',
            '10 km',
            '21 km',
            '42 km',
        ];

        foreach ($tiposProvas as $tipo) {
            TipoProva::create([
                'descricao' => $tipo
            ]);
        }
    }
}
