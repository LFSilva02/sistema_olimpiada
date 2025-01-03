<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Premiado;
use App\Models\Turma;
use App\Models\Olimpiada;
use Illuminate\Http\Request;

class PremiadoController extends Controller
{
    public function consultar()
    {
        $premiados = Premiado::with('aluno', 'olimpiada')->get();
        $alunos = Aluno::all();
        $turmas = Turma::all();
        $olimpiadas = Olimpiada::all();

        return view('premiados', compact('premiados', 'alunos', 'turmas', 'olimpiadas'));
    }

    public function cadastrar(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required',
            'medalha' => 'required',
            'olimpiada_id' => 'required',
            'turma_id' => 'required',
            'serie' => 'required',
        ]);

        Premiado::create($request->all());

        return redirect()->route('premiados.index')->with('success', 'Premiado cadastrado com sucesso!');
    }

    public function inativar(Request $request)
    {
        $premiado = Premiado::findOrFail($request->premiado_id);
        $premiado->ativo = 0;
        $premiado->save();

        return redirect()->route('premiados.index')->with('success', 'Premiado inativado com sucesso!');
    }

    public function ativar($id)
    {
        $premiado = Premiado::findOrFail($id);
        $premiado->ativo = 1;
        $premiado->save();

        return redirect()->route('premiados.index')->with('success', 'Premiado ativado com sucesso!');
    }
    public function getTurmasPorSerie($serie)
    {
        $turmas = Turma::where('serie', $serie)->get(['id', 'nome_turma']); // Selecionando apenas os campos necessários
        return response()->json($turmas);
    }
    public function editarPremiado(Request $request, $id)
{
    $request->validate([
        'aluno_id' => 'required',
        'medalha' => 'required',
        'olimpiada_id' => 'required',
        'turma_id' => 'required',
        'serie' => 'nullable', // Pode ser opcional se não for essencial
        'ativo' => 'required',
    ]);

    $premiado = Premiado::findOrFail($id);
    $premiado->update($request->only(['aluno_id', 'medalha', 'olimpiada_id', 'turma_id', 'ativo']));

    return redirect()->route('premiados.index')->with('success', 'Premiado atualizado com sucesso!');
}

}
