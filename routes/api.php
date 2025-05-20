<?php

use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/user', fn(Request $request) => $request->user());

    Route::prefix('admin')->middleware('admin')->group(function () {

        // endpoint CRUD consoles
        Route::get('/getallconsoles', [ConsoleController::class, 'index']);
        Route::post('/addconsoles', [ConsoleController::class, 'store']);
        Route::put('/updateconsoles/{console}', [ConsoleController::class, 'update']);
        Route::delete('/deleteconsoles/{console}', [ConsoleController::class, 'destroy']);
    });

    // endpoint customer
    Route::prefix('customer')->group(function () {
        Route::get('/listconsoles', [CustomerController::class, 'listconsole']);
        Route::get('/detailConsoles/{id_konsol}', [CustomerController::class, 'detailConsole']);
    });
});

// endpoint login dan register
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);


