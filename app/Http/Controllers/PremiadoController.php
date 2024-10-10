<?php

namespace App\Http\Controllers;

use App\Models\Premiado;
use App\Models\Turma;
use App\Models\Olimpiada;
use Illuminate\Http\Request;

class PremiadoController extends Controller
{
    // Método para listar todos os premiados
    public function index()
    {
        $premiados = Premiado::all(); // Buscar todos os premiados
        $turmas = Turma::all(); // Buscar todas as turmas
        $olimpiadas = Olimpiada::all(); // Buscar todas as olimpíadas
        return view('premiados', compact('premiados', 'turmas', 'olimpiadas'));
    }
    // Método para mostrar o formulário de criação de premiado
    public function create()
    {
        $turmas = Turma::all(); // Buscar todas as turmas
        $olimpiadas = Olimpiada::all(); // Buscar todas as olimpíadas
        return view('premiados.create', compact('turmas', 'olimpiadas'));
    }

    // Método para salvar o premiado no banco de dados
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomePremiado' => 'required|string|max:255',
            'medalha' => 'required|string',
            'turma' => 'required|exists:turmas,id',
            'olimpiada' => 'required|exists:olimpiadas,id',
        ]);

        $premiado = new Premiado();
        $premiado->nomePremiado = $validatedData['nomePremiado'];
        $premiado->medalha = $validatedData['medalha'];
        $premiado->turma_id = $validatedData['turma'];
        $premiado->olimpiada_id = $validatedData['olimpiada'];

        $premiado->save();

        return redirect()->route('premiados.index')->with('success', 'Premiado cadastrado com sucesso!');
    }
}
