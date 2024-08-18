<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignOutController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [SignInController::class, 'handle']);
Route::post('/logout', [SignOutController::class, 'handle']);
