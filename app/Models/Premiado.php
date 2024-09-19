<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premiado extends Model
{
    use HasFactory;

    protected $fillable = [
        'aluno_id',
        'olimpiada_id',
        'medalha',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function olimpíada()
    {
        return $this->belongsTo(Olimpiada::class);
    }
}
