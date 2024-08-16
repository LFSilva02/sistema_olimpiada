<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::with('turma')->where('status', 'ativo')->get();
        $turmas = Turma::all();
        return view('alunos', compact('alunos', 'turmas'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nomeAluno' => 'required|string|max:255',
        'turma_id' => 'required|exists:turmas,id',
    ]);

    Aluno::create([
        'nome' => $request->nomeAluno,
        'turma_id' => $request->turma_id,
        'status' => 'ativo',
    ]);

    return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso');
}

public function update(Request $request, $id)
{
    $request->validate([
        'nomeAluno' => 'required|string|max:255',
        'turma_id' => 'required|exists:turmas,id',
    ]);

    $aluno = Aluno::findOrFail($id);
    $aluno->update([
        'nome' => $request->nomeAluno,
        'turma_id' => $request->turma_id,
    ]);

    return redirect()->route('alunos.index')->with('success', 'Aluno atualizado com sucesso');
}

public function inativar(Request $request)
{
    $aluno = Aluno::findOrFail($request->aluno_id);
    $aluno->update(['status' => 'inativo']);

    return redirect()->route('alunos.index')->with('success', 'Aluno inativado com sucesso');
}

}
