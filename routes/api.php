<?php

use App\Http\Controllers\ClassificacaoController;
use App\Http\Controllers\CorredorController;
use App\Http\Controllers\CorredorEmProvaController;
use App\Http\Controllers\ProvaController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\TipoClassificacaoController;
use App\Http\Controllers\TipoProvaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/', function () {
    return "It's working";
});


Route::apiResources(['corredor-em-prova' => CorredorEmProvaController::class]);
Route::apiResources(['resultado' => ResultadoController::class]);
Route::apiResources(['tipo-prova' => TipoProvaController::class]);
Route::apiResources(['corredor' => CorredorController::class]);
Route::apiResources(['prova' => ProvaController::class]);


Route::prefix('classificacao')->group(function () {
    Route::get('gerar-classificacao/{prova_id}', [ClassificacaoController::class, 'gerarClassificacao']);
    Route::get('geral', [ClassificacaoController::class, 'consultaClassificacaoGeral']);
    Route::get('por-idade', [ClassificacaoController::class, 'consultaClassificacaoPorIdade']);
});
