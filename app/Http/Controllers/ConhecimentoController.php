<?php

namespace App\Http\Controllers;

use App\Models\Conhecimento;
use Illuminate\Http\Request;

class ConhecimentoController extends Controller
{
    public function index()
    {
        $conhecimentos = Conhecimento::all();
        return view('conhecimentos', ['conhecimentos' => $conhecimentos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomeConhecimento' => 'required',
            'descricao' => 'required'
        ]);

        // Verificar se já existe um conhecimento com o mesmo nome e descrição
        $exists = Conhecimento::where('nome_conhecimento', $request->input('nomeConhecimento'))
                              ->where('descricao', $request->input('descricao'))
                              ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Um conhecimento com o mesmo nome e descrição já existe.');
        }

        Conhecimento::create([
            'nome_conhecimento' => $request->input('nomeConhecimento'),
            'descricao' => $request->input('descricao'),
            'ativo' => 1,
        ]);

        return redirect()->route('conhecimentos.index');
    }

    public function update(Request $request, $id)
    {
        $conhecimento = Conhecimento::find($id);

        if (!$conhecimento) {
            return redirect()->route('conhecimentos.index')->with('error', 'Área de Conhecimento não encontrada');
        }

        $conhecimento->nome_conhecimento = $request->input('nome_conhecimento');
        $conhecimento->descricao = $request->input('descricao');
        $conhecimento->save();

        return redirect()->route('conhecimentos.index')->with('success', 'Área de Conhecimento atualizada com sucesso');
    }

    public function inativar(Request $request)
    {
        $id = $request->input('conhecimento_id');
        $conhecimento = Conhecimento::find($id);

        if ($conhecimento) {
            $conhecimento->ativo = 0;
            $conhecimento->save();
        }

        return redirect()->route('conhecimentos.index');
    }

    public function ativar($id)
    {
        $conhecimento = Conhecimento::find($id);

        if ($conhecimento) {
            $conhecimento->ativo = 1;
            $conhecimento->save();
        }

        return redirect()->route('conhecimentos.index');
    }
}
