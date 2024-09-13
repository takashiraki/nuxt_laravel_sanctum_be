<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\GenerateRestTokenController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\SignUpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [SignUpController::class, 'handle']);

Route::post('/password-reset-request', [GenerateRestTokenController::class, 'handle']);

Route::get('/password-reset/{reset_id}', [PasswordResetController::class, 'index']);

Route::post('/password-reset/{reset_id}', [PasswordResetController::class, 'handle']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
