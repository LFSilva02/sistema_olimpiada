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
Route::get('/turmas', [TurmaController::class, 'consultar'])->name('turmas.index');
Route::post('/turmas/store', [TurmaController::class, 'cadastrar'])->name('turmas.store');
Route::post('/turmas/inativar', [TurmaController::class, 'inativar'])->name('turmas.inativar');
Route::put('/turmas/{id}/ativar', [TurmaController::class, 'ativar'])->name('turmas.ativar');
Route::put('/turmas/{id}/update', [TurmaController::class, 'editar'])->name('turmas.update');
Route::get('/turmas/serie/{serie}', [TurmaController::class, 'getTurmasPorSerie']);



//CONHECIMENTOS
Route::get('/conhecimentos', [ConhecimentoController::class, 'consultar'])->name('conhecimentos.index');
Route::post('/conhecimentos', [ConhecimentoController::class, 'cadastrar'])->name('conhecimentos.store');
Route::post('/conhecimentos/inativar', [ConhecimentoController::class, 'inativar'])->name('conhecimentos.inativar');
Route::put('/conhecimentos/ativar/{id}', [ConhecimentoController::class, 'ativar'])->name('conhecimentos.ativar');
Route::put('/conhecimentos/{id}', [ConhecimentoController::class, 'editar'])->name('conhecimentos.update');


//OLIMPÍADAS
Route::get('olimpiadas', [OlimpiadaController::class, 'consultar'])->name('olimpiadas.index');
Route::post('olimpiadas', [OlimpiadaController::class, 'cadastrar'])->name('olimpiadas.store');
Route::put('olimpiadas/{id}', [OlimpiadaController::class, 'editar'])->name('olimpiadas.update');
Route::put('/olimpiadas/ativar/{id}', [OlimpiadaController::class, 'ativar'])->name('olimpiadas.ativar');
Route::post('/olimpiadas/inativar', [OlimpiadaController::class, 'inativar'])->name('olimpiadas.inativar');

//ALUNOS
Route::get('/alunos', [AlunoController::class, 'consultar'])->name('alunos.index');
Route::post('/alunos', [AlunoController::class, 'cadastrar'])->name('alunos.store');
Route::put('/alunos/{id}', [AlunoController::class, 'editar'])->name('alunos.update');
Route::get('/turmas/{turma}/alunos', [AlunoController::class, 'alunosDaTurma'])->name('turmas.alunos');
Route::put('/alunos/{id}/ativar', [AlunoController::class, 'ativar'])->name('alunos.ativar');
Route::post('/alunos/inativar', [AlunoController::class, 'inativar'])->name('alunos.inativar');
Route::get('alunos/{id}/edit', [AlunoController::class, 'edit'])->name('alunos.edit');
Route::get('/alunos/turma/{turmaId}', [AlunoController::class, 'getAlunosByTurma']);

//PREMIADOS
Route::get('/premiados', [PremiadoController::class, 'consultar'])->name('premiados.index');
Route::post('/premiados', [PremiadoController::class, 'cadastrar'])->name('premiados.store');
Route::put('/premiados/{id}', [PremiadoController::class, 'editar'])->name('premiados.update');
Route::post('/premiados/inativar', [PremiadoController::class, 'inativar'])->name('premiados.inativar');
Route::put('/premiados/ativar/{id}', [PremiadoController::class, 'ativar'])->name('premiados.ativar');
