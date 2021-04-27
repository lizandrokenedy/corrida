<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorredorEmProva extends Model
{
    use HasFactory;

    protected $table = 'corredores_em_provas';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [

    ];
}
