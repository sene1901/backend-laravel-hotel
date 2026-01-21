<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\NotificationController;

// ------------------ AUTHENTIFICATION ------------------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// ------------------ ROUTES PROTÉGÉES ------------------
Route::middleware('auth:sanctum')->group(function () {

    // Déconnexion et profil utilisateur
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Gestion des hôtels
    Route::get('/hotels', [HotelController::class, 'index']);       // Liste
    Route::post('/hotels', [HotelController::class, 'store']);      // Créer
    Route::get('/hotels/{hotel}', [HotelController::class, 'show']); // Détail
    Route::put('/hotels/{hotel}', [HotelController::class, 'update']); // Modifier
    Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy']); // Supprimer

    // Gestion des notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/mark-read/{id}', [NotificationController::class, 'markAsRead']);
});
Route::middleware('auth:sanctum')->post('/profile/imageprofil', [AuthController::class, 'updateProfile']);
Route::get('/test-mail', function () {
    \Mail::raw('Test email!', function ($message) {
        $message->to('sadiopro19@gmail.com')
                ->subject('Test Laravel Mail');
    });
    return 'Mail envoyé';
});
