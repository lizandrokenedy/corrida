<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    use HasFactory;

    protected $table = 'provas';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'tipo_prova_id',
        'data',
    ];

    protected $date = [
        'data'
    ];

    public function corredoresEmProvas()
    {
        return $this->hasMany(CorredorEmProva::class, 'prova_id', 'id');
    }

    public function tiposProvas()
    {
        return $this->belongsTo(TipoProva::class, 'tipo_prova_id', 'id');
    }
}
