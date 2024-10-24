<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Premiado;
use App\Models\Olimpiada;
use App\Models\Turma;
use Illuminate\Http\Request;

class PremiadoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::with('turma')->get();
        $premiados = Premiado::all();
        $olimpiadas = Olimpiada::all();
        return view('premiados', compact('premiados', 'olimpiadas', 'alunos'));
    }

    public function cadastrarPremiado(Request $request)
    {
        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'premiado_id' => 'required|exists:premiados,id',
            'medalha' => 'required|string',
            'ativo' => 'required|boolean',
        ]);

        Premiado::create($request->all());

        return redirect()->route('premiados.index')->with('success', 'Premiado cadastrado com sucesso!');
    }
    public function inativar(Request $request)
    {
        $id = $request->input('premiado_id');
        $premiado = Premiado::find($id);

        if ($premiado) {
            $premiado->ativo = 0;
            $premiado->save();
        }

        return redirect()->route('premiados.index')->with('success', 'Premiado inativada com sucesso');
    }

    public function ativar(Request $request, $id)
    {
        $premiado = Premiado::find($id);

        if ($premiado) {
            $premiado->ativo = 1;
            $premiado->save();
        }

        return redirect()->route('premiados.index')->with('success', 'Premiado ativada com sucesso');
    }

}
