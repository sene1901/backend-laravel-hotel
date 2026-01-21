<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Le serveur Laravel fonctionne ";
});

Route::get('/password/reset/{token}', function ($token) {
    return response()->json([
        'token' => $token
    ]);
})->name('password.reset');
