<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Premiado;

class PremiadoController extends Controller
{
    // Exibir os premiados por categoria
    public function index()
    {
        $premiados = Premiado::all()->groupBy('categoria');
        return view('premiados', compact('premiados'));
    }

    // Criar novo premiado
    public function store(Request $request)
    {
        $premiado = new Premiado();
        $premiado->nome = $request->nomePremiado;
        $premiado->categoria = $request->categoria;
        $premiado->ativo = true;
        $premiado->save();

        return redirect()->route('premiados.index');
    }

    // Editar premiado
    public function update(Request $request, $id)
    {
        $premiado = Premiado::find($id);
        $premiado->nome = $request->nomePremiado;
        $premiado->categoria = $request->categoria;
        $premiado->save();

        return redirect()->route('premiados.index');
    }

    // Ativar premiado
    public function ativar($id)
    {
        $premiado = Premiado::find($id);
        $premiado->ativo = true;
        $premiado->save();

        return redirect()->route('premiados.index');
    }

    // Inativar premiado
    public function inativar(Request $request)
    {
        $premiado = Premiado::find($request->premiado_id);
        $premiado->ativo = false;
        $premiado->save();

        return redirect()->route('premiados.index');
    }
}
