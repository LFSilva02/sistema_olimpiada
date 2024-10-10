<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = ['serie', 'nome_turma'];

    public function premiados()
    {
        return $this->hasMany(Premiado::class);
    }
}
