<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EquipeController;
use App\Http\Controllers\Api\OrientadorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjetoController;
use App\Http\Controllers\Api\TesteController;
use App\Http\Controllers\Api\DocumentoProjetoController;
use App\Http\Controllers\Api\AvaliacaoController;
use App\Http\Controllers\Api\RankingController;
use App\Http\Controllers\Api\PublicoController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::prefix('publico')->group(function () {
    Route::get('/projetos', [PublicoController::class, 'projetos']);
    Route::get('/projetos/{id}', [PublicoController::class, 'projeto']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::prefix('/usuarios')->group(function () {
        Route::get('/pendentes', [OrientadorController::class, 'pendentes']);
        Route::get('/aprovados', [OrientadorController::class, 'aprovados']);
        Route::post('/aprovar', [OrientadorController::class, 'aprovar']);
        Route::post('/reprovar', [OrientadorController::class, 'reprovar']);
    });

    Route::prefix('equipes')->group(function () {
        Route::get('/', [EquipeController::class, 'index']);
        Route::get('/{id}', [EquipeController::class, 'show']);
        Route::post('/', [EquipeController::class, 'store']);
        Route::post('/integrantes', [EquipeController::class, 'adicionarIntegrante']);
        Route::delete('/integrantes/{id}', [EquipeController::class, 'removerIntegrante']);
    });

    Route::prefix('projetos')->group(function () {
        Route::get('/', [ProjetoController::class, 'index']);
        Route::get('/{id}', [ProjetoController::class, 'show']);
        Route::post('/', [ProjetoController::class, 'store']);
        Route::put('/{id}', [ProjetoController::class, 'update']);
        Route::post('/{id}/aprovar', [ProjetoController::class, 'aprovar']);

        Route::get('/{projetoId}/testes', [TesteController::class, 'index']);
        Route::post('/{projetoId}/testes', [TesteController::class, 'store']);

        Route::get('/{projetoId}/documentos', [DocumentoProjetoController::class, 'index']);
        Route::post('/{projetoId}/documentos', [DocumentoProjetoController::class, 'store']);
    });

    Route::prefix('projetos')->group(function () {
        Route::get('/{projetoId}/avaliacoes', [AvaliacaoController::class, 'index']);
        Route::post('/{projetoId}/avaliacoes', [AvaliacaoController::class, 'store']);
    });

    Route::get('/ranking', [RankingController::class, 'index']);

});
