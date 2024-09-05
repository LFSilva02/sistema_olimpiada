<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index()
    {
        $turmas = Turma::with('alunos')->get();
        return view('alunos', compact('turmas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'turma_id' => 'required|exists:turmas,id',
            'ativo' => 'required|boolean',
        ]);

        Aluno::create($request->all());

        return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso.');
    }

    public function showAlunosDaTurma($turmaId)
    {
        $alunos = Aluno::where('turma_id', $turmaId)->get();
        return response()->json(['alunos' => $alunos]);
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->delete();
        return redirect()->route('alunos.index')->with('success', 'Aluno excluído com sucesso.');
    }
}
