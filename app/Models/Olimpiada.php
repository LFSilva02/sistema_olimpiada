<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Olimpiada extends Model
{
    use HasFactory;

    // Defina quais campos podem ser atribuídos em massa
    protected $fillable = [
        'nome_olimpiada',
        'data_olimpiada',
        'horario',
        'local',
        'sala',
        'ativo'
    ];
}
