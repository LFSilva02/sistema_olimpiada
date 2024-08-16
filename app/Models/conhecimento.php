<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conhecimento extends Model
{
    use HasFactory;
    protected $table = 'conhecimentos';

    protected $fillable = [
        'nome_conhecimento',
        'descricao',
        'ativo'
    ];
}
