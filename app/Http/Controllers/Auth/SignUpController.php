<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class SignUpController extends Controller
{
    public function handle(
        SignUpRequest $http_request
    ) {
        DB::beginTransaction();
        try {
            User::create(
                [
                    'name' => $http_request->name,
                    'email' => $http_request->email,
                    'password' => $http_request->password,
                ]
            );
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json(
                [
                    'handle_error' => $exception->getMessage(),
                ],
                500
            );
        }

        return response()->json();
    }
}
