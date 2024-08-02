<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MobilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("/login", [AuthController::class, 'index']);

Route::get('/mobils', [MobilController::class, 'get']);
Route::get('/mobils/{id}', [MobilController::class, 'getById']);

Route::middleware("auth:sanctum")->group(function () {
    Route::post('/mobils', [MobilController::class, 'store']);
    Route::put('/mobils/{id}', [MobilController::class, 'update']);
    Route::delete('/mobils/{id}', [MobilController::class, 'destroy']);
});
