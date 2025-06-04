<?php

use App\Http\Controllers\AccesoriesController;
use App\Http\Controllers\BookingsController;
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

        // endpoint Read and Delete booking
        Route::get('/getallbooking', [BookingsController::class, 'index']);
        Route::delete('/deleteBooking/{bookings}', [BookingsController::class, 'destroy']);
    });

    // endpoint customer
    Route::prefix('customer')->group(function () {
        Route::get('/products', [CustomerController::class, 'listconsole']);
        Route::get('/detailProducts/{id_konsol}', [CustomerController::class, 'detailConsole']);
        Route::get('/aksesoris', [CustomerController::class, 'accessories']);
        Route::get('/detailAksesories/{id_aksesoris}', [CustomerController::class, 'detailAccesories']);
        Route::post('/booking', [CustomerController::class, 'bookingPlaystation']);
        Route::get('/getBooking', [CustomerController::class, 'getBooking']);
        Route::delete('/cancel-booking/{$id}', [CustomerController::class, 'cancelBooking']);
    });
});

// endpoint login dan register
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);


