<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\ConhecimentoController;
use App\Http\Controllers\OlimpiadaController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\PremiadoController;

Route::get('/', function () {
    return view('welcome');
});

//TURMAS
Route::get('/turmas', [TurmaController::class, 'index'])->name('turmas.index');
Route::post('/turmas/store', [TurmaController::class, 'store'])->name('turmas.store');
Route::post('/turmas/inativar', [TurmaController::class, 'inativar'])->name('turmas.inativar');
Route::put('/turmas/{id}/ativar', [TurmaController::class, 'ativar'])->name('turmas.ativar');
Route::put('/turmas/{id}/update', [TurmaController::class, 'update'])->name('turmas.update');


//CONHECIMENTOS
Route::get('/conhecimentos', [ConhecimentoController::class, 'index'])->name('conhecimentos.index');
Route::post('/conhecimentos', [ConhecimentoController::class, 'store'])->name('conhecimentos.store');
Route::post('/conhecimentos/inativar', [ConhecimentoController::class, 'inativar'])->name('conhecimentos.inativar');
Route::put('/conhecimentos/ativar/{id}', [ConhecimentoController::class, 'ativar'])->name('conhecimentos.ativar');
Route::put('/conhecimentos/{id}', [ConhecimentoController::class, 'update'])->name('conhecimentos.update');


//OLIMPÍADAS
Route::get('olimpiadas', [OlimpiadaController::class, 'index'])->name('olimpiadas.index');
Route::post('olimpiadas', [OlimpiadaController::class, 'store'])->name('olimpiadas.store');
Route::put('olimpiadas/{id}', [OlimpiadaController::class, 'update'])->name('olimpiadas.update');
Route::put('/olimpiadas/ativar/{id}', [OlimpiadaController::class, 'ativar'])->name('olimpiadas.ativar');
Route::post('/olimpiadas/inativar', [OlimpiadaController::class, 'inativar'])->name('olimpiadas.inativar');

//ALUNOS
Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');
Route::post('/alunos', [AlunoController::class, 'store'])->name('alunos.store');
Route::put('/alunos/{id}', [AlunoController::class, 'update'])->name('alunos.update');
Route::get('/turmas/{turma}/alunos', [AlunoController::class, 'alunosDaTurma'])->name('turmas.alunos');
Route::get('/alunos/{id}/ativar', [AlunoController::class, 'ativar'])->name('alunos.ativar');
Route::get('/alunos/{id}/inativar', [AlunoController::class, 'inativar'])->name('alunos.inativar');

//PREMIADOS
Route::get('/premiados', [PremiadoController::class, 'index'])->name('premiados.index');
Route::post('/premiados', [PremiadoController::class, 'cadastrarPremiado'])->name('premiados.store');
Route::put('/premiados/{id}', [PremiadoController::class, 'update'])->name('premiados.update');
Route::put('/premiados/ativar/{id}', [PremiadoController::class, 'ativar'])->name('premiados.ativar');
Route::post('/premiados/inativar', [PremiadoController::class, 'inativar'])->name('premiados.inativar');
