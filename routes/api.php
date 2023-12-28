<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

// ROTAS AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// ROTAS USER
Route::get('/me', [UserController::class, 'me'])->middleware('auth:sanctum');

// ROTAS TASK
Route::get('/task', [TaskController::class, 'index'])->middleware('auth:sanctum');
Route::post('/task', [TaskController::class, 'store'])->middleware('auth:sanctum');
Route::put('/task/{id}', [TaskController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/task/{id}', [TaskController::class, 'destroy'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
