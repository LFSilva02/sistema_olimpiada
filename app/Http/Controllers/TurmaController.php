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
        return view('turmas', ['turmas' => $turmas]);
    }

    // Método para armazenar uma nova turma
    public function store(Request $request)
    {
        $request->validate([
            'nomeTurma' => 'required|string|max:255',
            'serie' => 'required|integer',
            'ano' => 'required|integer',
        ]);

        $turma = new Turma;
        $turma->nome_turma = $request->input('nomeTurma');
        $turma->serie = $request->input('serie');
        $turma->ano = $request->input('ano');
        $turma->ativo = true;
        $turma->save();

        return redirect()->route('turmas.index');
    }

    // Método para atualizar uma turma existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomeTurma' => 'required|string|max:255',
            'serie' => 'required|integer',
            'ano' => 'required|integer',
        ]);

        $turma = Turma::findOrFail($id);
        $turma->nome_turma = $request->input('nomeTurma');
        $turma->serie = $request->input('serie');
        $turma->ano = $request->input('ano');
        $turma->save();

        return redirect()->route('turmas.index');
    }

    // Método para inativar uma turma
    public function inativar(Request $request)
    {
        $turma = Turma::findOrFail($request->input('turma_id'));
        $turma->ativo = false;
        $turma->save();

        return redirect()->route('turmas.index');
    }

    // Método para ativar uma turma
    public function ativar($id)
    {
        $turma = Turma::findOrFail($id);
        $turma->ativo = true;
        $turma->save();

        return redirect()->route('turmas.index');
    }
}
