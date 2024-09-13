<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GenerateRestTokenRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class GenerateRestTokenController extends Controller
{
    public function handle(
        GenerateRestTokenRequest $http_request
    ) {
        if (! User::where('email', $http_request->email)->exists()) {
            return response()->json(
                [
                    'message' => 'User not found',
                ],
                404
            );
        }

        DB::beginTransaction();
        try {
            PasswordReset::create(
                [
                    'reset_id' => bin2hex(random_bytes(18)),
                    'email' => $http_request->email,
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
