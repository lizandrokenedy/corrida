<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificacaoPorIdade extends Model
{
    use HasFactory;

    protected $table = 'classificacao_por_idade';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'idade',
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
