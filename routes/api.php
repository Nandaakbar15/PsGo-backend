<?php

use App\Http\Controllers\AccesoriesController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/user', fn(Request $request) => $request->user());

    Route::prefix('admin')->middleware('admin')->group(function () {

        // endpoint untuk melihat semua user dan delete user
        Route::get("/getallusers", [UserController::class, 'users']);
        Route::delete("/deleteUser/{user}", [UserController::class, 'deleteUser']);

        // endpoint CRUD consoles
        Route::get('/getallconsoles', [ConsoleController::class, 'index']);
        Route::get('/getallconsoles/{console}', [ConsoleController::class, 'show']);
        Route::post('/addconsoles', [ConsoleController::class, 'store']);
        Route::put('/updateconsoles/{console}', [ConsoleController::class, 'update']);
        Route::delete('/deleteconsoles/{console}', [ConsoleController::class, 'destroy']);

        // endpoint CRUD Accesories
        Route::get('/getallaccesories', [AccesoriesController::class, 'index']);
        Route::get('/getallaccesories/{accesories}', [AccesoriesController::class, 'show']);
        Route::post('/addaccesories', [AccesoriesController::class, 'store']);
        Route::put('/updateaccesories/{accesories}', [AccesoriesController::class, 'update']);
        Route::delete('/deleteaccesories/{accesories}', [AccesoriesController::class, 'destroy']);
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


