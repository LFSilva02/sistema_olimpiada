<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Premiado;
use App\Models\Turma;
use App\Models\Aluno;
use App\Models\Olimpiada;

class PremiadoController extends Controller
{
    // Listar todos os premiados agrupados por olimpíada
    public function index()
    {
        $premiados = Premiado::all()->groupBy('olimpiada');
        $alunos = Aluno::all();
        $turmas = Turma::all();
        $olimpiadas = Olimpiada::all();
        return view('premiados', compact('premiados','alunos', 'turmas','olimpiadas'));
    }

    // Salvar um novo premiado
    public function store(Request $request)
    {
        $request->validate([
            'nomeAluno' => 'required|string|max:255',
            'medalha' => 'required|string|max:255',
            'olimpiada' => 'required|string|max:255',
        ]);

        Premiado::create([
            'nome' => $request->nomeAluno,
            'medalha' => $request->medalha,
            'olimpiada' => $request->olimpiada,
        ]);

        return redirect()->route('premiados.index')->with('success', 'Premiado cadastrado com sucesso.');
    }

    // Editar premiado
    public function editar($id, Request $request)
    {
        $premiado = Premiado::
        find($id);
        $request->validate([
            'nomeAluno' => 'required|string|max:255',
            'medalha' => 'required|string|max:255',
            'olimpiada' => 'required|string|max:255',
        ]);

        $premiado->update([
            'nome' => $request->nomeAluno,
            'medalha' => $request->medalha,
            'olimpiada' => $request->olimpiada,
        ]);

        return redirect()->route('premiados.index')->with('success', 'Premiado atualizado com sucesso.');
    }

    // Remover premiado
    public function remover($id)
    {
        $premiado = Premiado::find($id);
        $premiado->delete();

        return redirect()->route('premiados.index')->with('success', 'Premiado removido com sucesso.');
    }
}
