<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificacaoGeral extends Model
{
    use HasFactory;

    protected $table = 'classificacao_geral';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'posicao',
        'corredor_id',
        'prova_id',
    ];

    public function corredores()
    {
        return $this->belongsTo(Corredor::class, 'corredor_id', 'id');
    }

    public function provas()
    {
        return $this->belongsTo(Prova::class, 'prova_id', 'id');
    }
}
