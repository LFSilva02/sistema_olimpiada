<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\ConhecimentoController;
use App\Http\Controllers\OlimpiadaController;
use App\Http\Controllers\AlunoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/turmas', [TurmaController::class, 'index'])->name('turmas.index');
Route::post('/turmas', [TurmaController::class, 'store'])->name('turmas.store');
Route::put('/turmas/{id}', [TurmaController::class, 'update'])->name('turmas.update');
Route::post('/turmas/inativar', [TurmaController::class, 'inativar'])->name('turmas.inativar');
Route::put('/turmas/ativar/{id}', [TurmaController::class, 'ativar'])->name('turmas.ativar');

Route::get('/conhecimentos', [ConhecimentoController::class, 'index'])->name('conhecimentos.index');
Route::post('/conhecimentos', [ConhecimentoController::class, 'store'])->name('conhecimentos.store');
Route::put('/conhecimentos/{id}', [ConhecimentoController::class, 'update'])->name('conhecimentos.update');
Route::delete('/conhecimentos/{id}', [ConhecimentoController::class, 'destroy'])->name('conhecimentos.destroy');
Route::post('/conhecimentos/inativar', [ConhecimentoController::class, 'inativar'])->name('conhecimentos.inativar');
Route::put('/conhecimentos/ativar/{id}', [ConhecimentoController::class, 'ativar'])->name('conhecimentos.ativar');

Route::get('olimpiadas', [OlimpiadaController::class, 'index'])->name('olimpiadas.index');
Route::post('olimpiadas', [OlimpiadaController::class, 'store'])->name('olimpiadas.store');
Route::put('olimpiadas/{id}', [OlimpiadaController::class, 'update'])->name('olimpiadas.update');
Route::put('/olimpiadas/ativar/{id}', [OlimpiadaController::class, 'ativar'])->name('olimpiadas.ativar');
Route::post('/olimpiadas/inativar', [OlimpiadaController::class, 'inativar'])->name('olimpiadas.inativar');

Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');
Route::post('/alunos', [AlunoController::class, 'store'])->name('alunos.store');
Route::put('/alunos/{id}', [AlunoController::class, 'update'])->name('alunos.update');
Route::post('/alunos/inativar', [AlunoController::class, 'inativar'])->name('alunos.inativar');


