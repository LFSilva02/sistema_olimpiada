<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Premiado;
use App\Models\Turma;
use App\Models\Olimpiada;
use Illuminate\Http\Request;

class PremiadoController extends Controller
{
    public function index()
    {
        $premiados = Premiado::with('aluno', 'olimpiada')->get();
        $alunos = Aluno::all();
        $turmas = Turma::all();
        $olimpiadas = Olimpiada::all();

        return view('premiados', compact('premiados', 'alunos', 'turmas', 'olimpiadas'));
    }

    public function cadastrarPremiado(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required',
            'medalha' => 'required',
            'olimpiada_id' => 'required',
            'turma_id' => 'required',
            'serie' => 'required',
            'ativo' => 'required',
        ]);

        Premiado::create($request->all());

        return redirect()->route('premiados.index')->with('success', 'Premiado cadastrado com sucesso!');
    }
    public function editarPremiado(Request $request, $id)
    {
        $request->validate([
            'aluno_id' => 'required',
            'medalha' => 'required',
            'olimpiada_id' => 'required',
            'turma_id' => 'required',
            // 'serie' => 'required',
            'ativo' => 'required',
        ]);

        $premiado = Premiado::findOrFail($id);
        $premiado->update($request->all());

        return redirect()->route('premiados.index')->with('success', 'Premiado atualizado com sucesso!');
    }

    public function inativarPremiado(Request $request)
    {
        $premiado = Premiado::findOrFail($request->premiado_id);
        $premiado->ativo = 0;
        $premiado->save();

        return redirect()->route('premiados.index')->with('success', 'Premiado inativado com sucesso!');
    }

    public function ativarPremiado($id)
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
}
