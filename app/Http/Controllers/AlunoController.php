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

    $aluno->nome = $request->input('nome');

    // Agora, em vez de buscar pelo nome da turma, você pega o ID diretamente:
    $aluno->turma_id = $request->input('turma_nome'); // Aqui você pega o ID da turma selecionada

    $aluno->ativo = $request->input('ativo');

    $aluno->save();

    return redirect()->route('turmas.alunos', ['turma' => $aluno->turma_id])
                     ->with('success', 'Aluno atualizado com sucesso.');
}

}
