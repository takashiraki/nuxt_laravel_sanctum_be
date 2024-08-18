<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    public function handle(
        SignInRequest $http_request
    ) {
        $credentials = $http_request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $http_request->session()->regenerate();

            return response()->json(
                [
                    'message' => 'Authenticated',
                ]
            );
        }

        throw new AuthenticationException('Credentials error');
    }
}
