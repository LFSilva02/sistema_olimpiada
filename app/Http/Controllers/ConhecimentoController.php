<?php

namespace App\Http\Controllers;

use App\Models\Conhecimento;
use Illuminate\Http\Request;

class ConhecimentoController extends Controller
{
    public function index()
    {
        $conhecimentos = Conhecimento::all();
        return view('conhecimentos', compact('conhecimentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome_conhecimento' => 'required',
            'descricao' => 'required'
        ]);

        // Verifica se já existe um conhecimento com o mesmo nome e descrição
        $exists = Conhecimento::where('nome_conhecimento', $request->nome_conhecimento)
            ->where('descricao', $request->descricao)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Um conhecimento com o mesmo nome e descrição já existe.');
        }

        Conhecimento::create([
            'nome_conhecimento' => $request->nome_conhecimento,
            'descricao' => $request->descricao,
            'ativo' => 1,
        ]);

        return redirect()->route('conhecimentos.index');
    }

    public function inativar(Request $request)
    {
        $conhecimento = Conhecimento::findOrFail($request->conhecimento_id);
        $conhecimento->ativo = 0;
        $conhecimento->save();

        return redirect()->route('conhecimentos.index');
    }

    public function ativar($id)
    {
        $conhecimento = Conhecimento::findOrFail($id);
        $conhecimento->ativo = 1;
        $conhecimento->save();

        return redirect()->route('conhecimentos.index');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome_conhecimento' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
        ]);

        $conhecimento = Conhecimento::findOrFail($id);
        $conhecimento->nome_conhecimento = $request->nome_conhecimento;
        $conhecimento->descricao = $request->descricao;
        $conhecimento->save();

        return redirect()->route('conhecimentos.index')->with('success', 'Área de conhecimento atualizada com sucesso!');
    }
}
