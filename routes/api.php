<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EnderecoController;
use App\Http\Controllers\Api\V1\PrestadorController;
use App\Http\Controllers\Api\V1\ServicoController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


request()->headers->set('Accept', 'application/json');

Route::post('/auth',[AuthController::class,'authenticate']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/servico', [ServicoController::class,'getServicos'] );
    Route::get('/buscarCoordenadas/{endereco}', [EnderecoController::class,'getCoordenadaEndereco'] );
    Route::post('/buscarPrestadores', [PrestadorController::class,'getPrestadores'] );
    Route::get('/logout', [AuthController::class,'logout'] );
    Route::get('/getEnderecosDisponiveis', [PrestadorController::class,'getEnderecosDisponiveis']);
});