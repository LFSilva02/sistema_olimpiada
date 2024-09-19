<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Olimpiada;
use App\Models\Premiado;
use Illuminate\Http\Request;

class PremiadosController extends Controller
{
    // Exibe a lista de premiados
    public function index()
    {
        $premiados = Premiado::with('aluno.turma')->get()->groupBy(function($premiado) {
            return $premiado->aluno->turma->serie;
        });

        $alunos = Aluno::all();
        $olimpiadas = Olimpiada::all();

        return view('premiados', compact('premiados', 'alunos', 'olimpiadas'));
    }

    // Armazena um novo premiado
    public function store(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required',
            'medalha' => 'required',
            'olimpiada_id' => 'required',
        ]);

        Premiado::create($request->all());

        return redirect()->route('premiados.index');
    }

    // Atualiza um premiado existente
    public function update(Request $request, $id)
    {
        $premiado = Premiado::findOrFail($id);

        $premiado->update($request->all());

        return redirect()->route('premiados.index');
    }

    // Remove um premiado
    public function destroy($id)
    {
        $premiado = Premiado::findOrFail($id);
        $premiado->delete();

        return redirect()->route('premiados.index');
    }
}

