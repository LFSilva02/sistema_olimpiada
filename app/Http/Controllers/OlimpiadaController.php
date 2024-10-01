<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Olimpiada;

class OlimpiadaController extends Controller
{
    public function index()
    {
        // Busque todas as Olimpíadas no banco de dados
        $olimpiadas = Olimpiada::all();

        // Retorne a vista com os dados
        return view('olimpiadas', compact('olimpiadas'));
    }

    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'nome_olimpiada' => 'required|string|max:255',
            'data_olimpiada' => 'required|date',
            'horario' => 'required|date_format:H:i',
            'local' => 'required|string|max:255',
            'sala' => 'required|string|max:255',
            'ativo' => 'boolean'
        ]);

        // Criação da olimpíada no banco de dados
        Olimpiada::create($request->only([
            'nome_olimpiada',
            'data_olimpiada',
            'horario',
            'local',
            'sala',
            'ativo'
        ]));

        // Redirecionar de volta com uma mensagem de sucesso
        return redirect()->route('olimpiadas.index')->with('success', 'Olimpíada cadastrada com sucesso!');
    }
    public function update(Request $request, $id)
    {
        $olimpiada = Olimpiada::find($id);

        if (!$olimpiada) {
            return redirect()->route('olimpiadas.index')->with('error', 'Área de olimpiada não encontrada');
        }

        $olimpiada->nome_olimpiada = $request->input('nome_olimpiada');
        $olimpiada->data_olimpiada = $request->input('data_olimpiada');
        $olimpiada->horario = $request->input('horario');
        $olimpiada->local = $request->input('local');
        $olimpiada->sala = $request->input('sala');
        $olimpiada->save();

        return redirect()->route('olimpiadas.index')->with('success', 'Área de olimpiada atualizada com sucesso');
    }
    public function inativar(Request $request)
    {
        $id = $request->input('olimpiada_id');
        $olimpiada = Olimpiada::find($id);

        if ($olimpiada) {
            $olimpiada->ativo = 0;
            $olimpiada->save();
        }

        return redirect()->route('olimpiadas.index')->with('success', 'Olimpíada inativada com sucesso');
    }

    public function ativar(Request $request, $id)
{
    $olimpiada = Olimpiada::find($id);

    if ($olimpiada) {
        $olimpiada->ativo = 1;
        $olimpiada->save();
    }

    return redirect()->route('olimpiadas.index')->with('success', 'Olimpíada ativada com sucesso');
}
}
