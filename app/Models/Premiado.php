<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premiado extends Model
{
    use HasFactory;

    protected $table = 'premiados';
    protected $fillable = ['aluno_id', 'medalha', 'olimpiada_id', 'ativo', 'turma_id'];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function olimpiada()
    {
        return $this->belongsTo(Olimpiada::class);
    }
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
