<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::with('turma')->get();
        $turmas = Turma::all();
        return view('alunos', compact('alunos', 'turmas'));
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

    public function alunosDaTurma($turmaId)
    {
        $turma = Turma::findOrFail($turmaId);
        $alunos = $turma->alunos;
        $turmas = Turma::all();

        return view('alunos_da_turma', compact('turma', 'alunos', 'turmas'));
    }

    public function ativar($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->ativo = true;
        $aluno->save();

        return redirect()->back()->with('success', 'Aluno ativado com sucesso!');
    }

    public function inativar($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->ativo = false;
        $aluno->save();

        return redirect()->back()->with('success', 'Aluno inativado com sucesso!');
    }

    public function update(Request $request, $id)
{
    $aluno = Aluno::findOrFail($id);

    $request->validate([
        'nome' => 'required',
        'turma_id' => 'required|exists:turmas,id',
        'ativo' => 'required|boolean',
    ]);

    $aluno->nome = $request->input('nome');
    $aluno->turma_id = $request->input('turma_id'); // Adicione esta linha
    $aluno->ativo = $request->input('ativo');

    $aluno->save();

    return redirect()->route('alunos.index')->with('success', 'Aluno atualizado com sucesso.');
}
    public function edit($id)
    {
        $aluno = Aluno::with('turma')->findOrFail($id);
        $turmas = Turma::all();        $turma = Turma::findOrFail($id); $alunos = Aluno::with('turma')->get();

        return view('alunos_da_turma', compact('aluno', 'turmas', 'turma'));
    }
    public function getAlunosByTurma($turmaId)
    {
        // Busca alunos da turma específica
        $alunos = Aluno::where('turma_id', $turmaId)->get();
        return response()->json($alunos);
    }
}
