<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ContaBancariaController;
use TheSeer\Tokenizer\NamespaceUri;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('contas', ContaBancariaController::class);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::resource('contas', 'ContaBancariaController')->middleware('auth:sanctum') ;

// Route::namespace('Api')->group(function () {
//     Route::resource('contas', 'ContaBancariaController');
    
// });

// Route::resource('contas', 'ContaBancariaController');

// Route::middleware('auth:sanctum')->group(function () {
//     Route::resource('despesas', 'DespesasController');
//     Route::resource('transacoes', 'TransacoesController');
// });
