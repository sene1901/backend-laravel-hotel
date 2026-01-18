<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\HotelController;
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);





Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/hotels', [HotelController::class, 'index']);      // LISTE
    Route::post('/hotels', [HotelController::class, 'store']);     // CRÉER
    Route::get('/hotels/{hotel}', [HotelController::class, 'show']); // DÉTAIL
    Route::put('/hotels/{hotel}', [HotelController::class, 'update']); // MODIFIER
    Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy']); // SUPPRIMER
});