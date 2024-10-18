<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = ['serie', 'nome_turma', 'ano'];

    public function premiados()
    {
        return $this->hasMany(Premiado::class);
    }
    public function alunos()
    {
        return $this->hasMany(Aluno::class, 'turma_id');
    }
}
