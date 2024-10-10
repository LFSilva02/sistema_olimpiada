<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turma;

class TurmaController extends Controller
{
    // Método para exibir as turmas
    public function index()
{
    $turmas = Turma::all()->groupBy('serie');
    return view('turmas', compact('turmas'));
}

public function store(Request $request)
{
    $request->validate([
        'nomeTurma' => 'required|string|max:255',
        'serie' => 'required|integer',
        'ano' => 'required|integer',
    ]);

    Turma::create([
        'nome_turma' => $request->input('nomeTurma'),
        'serie' => $request->input('serie'),
        'ano' => $request->input('ano'),
        'ativo' => true,
    ]);

    return redirect()->route('turmas.index');
}

public function update(Request $request, $id)
{
    $request->validate([
        'nomeTurma' => 'required|string|max:255',
        'serie' => 'required|integer',
        'ano' => 'required|integer',
    ]);

    $turma = Turma::findOrFail($id);
    $turma->update([
        'nome_turma' => $request->input('nomeTurma'),
        'serie' => $request->input('serie'),
        'ano' => $request->input('ano'),
    ]);

    return redirect()->route('turmas.index');
}

public function inativar(Request $request)
{
    $turma = Turma::findOrFail($request->input('turma_id'));
    $turma->ativo = false;
    $turma->save();

    return redirect()->route('turmas.index');
}

public function ativar($id)
{
    $turma = Turma::findOrFail($id);
    $turma->ativo = true;
    $turma->save();

    return redirect()->route('turmas.index');
}
}
