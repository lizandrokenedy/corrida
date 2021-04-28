<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProva extends Model
{
    use HasFactory;

    protected $table = 'tipos_provas';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'descricao'
    ];

    public function provas()
    {
        return $this->hasMany(Prova::class, 'tipo_prova_id', 'id');
    }
}
