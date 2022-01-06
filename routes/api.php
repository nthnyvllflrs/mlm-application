<?php

use App\Http\Controllers\GenealogyController;
use App\Http\Controllers\RepresentativeController;
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

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::apiResource('representatives', RepresentativeController::class);
    Route::apiResource('genealogies', GenealogyController::class);
});
