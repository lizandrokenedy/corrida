<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoClassificacao extends Model
{
    use HasFactory;

    protected $table = 'tipos_classificacoes';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'descricao',
    ];

}
