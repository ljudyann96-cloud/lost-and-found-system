<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Public Authentication Routes ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- Protected Routes (Requires Bearer Token) ---
Route::middleware('auth:sanctum')->group(function () {
    // Auth Management
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Protected Item Routes
    Route::get('/items', [ItemController::class, 'index']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::patch('/items/{item}', [ItemController::class, 'update']); 
    Route::patch('/items/{item}/status', [ItemController::class, 'updateStatus']);
    Route::delete('/items/{item}', [ItemController::class, 'destroy']);
});