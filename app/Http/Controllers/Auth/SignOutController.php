<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignOutController extends Controller
{
    public function handle(Request $http_request)
    {
        Auth::guard('web')->logout();

        $http_request->session()->invalidate();
        $http_request->session()->regenerateToken();

        return response()->json();
    }
}
