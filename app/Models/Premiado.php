<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premiado extends Model
{
    use HasFactory;

    protected $fillable = ['nomePremiado', 'medalha', 'turma_id', 'olimpiada_id'];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function olimpiada()
    {
        return $this->belongsTo(Olimpiada::class);
    }
}
