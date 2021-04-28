<?php

namespace App\Models;

use App\Casts\CpfCast;
use App\Casts\DataBrCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corredor extends Model
{
    use HasFactory;

    protected $table = 'corredores';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'idade',
    ];

    protected $dates = [
        'data_nascimento'
    ];

    public function corredoresEmProvas()
    {
        return $this->hasMany(CorredorEmProva::class, 'corredor_id', 'id');
    }
}
