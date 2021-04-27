<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    protected $table = 'resultados';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'corredor_id',
        'prova_id',
        'hora_inicio_prova',
        'hora_conclusao_prova',
    ];
}
