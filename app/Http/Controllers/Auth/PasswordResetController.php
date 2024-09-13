<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    private const LENGTH = 36;

    public function index(string $reset_id)
    {
        if (mb_strlen($reset_id) !== self::LENGTH) {
            return response()->json(
                [
                    'message' => 'Invalid reset ID',
                ],
                400
            );
        }

        if (! PasswordReset::where('reset_id', $reset_id)->exists()) {
            return response()->json(
                [
                    'message' => 'Reset ID not found',
                ],
                404
            );
        }

        return response()->json(
            [
                'reset_id' => $reset_id,
            ]
        );
    }

    public function handle(
        PasswordResetRequest $http_request,
        string $reset_id
    ) {
        if (mb_strlen($reset_id) !== self::LENGTH
        || $reset_id !== $http_request->reset_id) {
            return response()->json(
                [
                    'message' => 'Invalid reset ID',
                ],
                400
            );
        }

        if (! PasswordReset::where('reset_id', $reset_id)->exists()) {
            return response()->json(
                [
                    'message' => 'Reset ID not found',
                ],
                404
            );
        }

        DB::beginTransaction();
        try {
            User::where('email', $http_request->email)->update(
                [
                    'password' => $http_request->password,
                ]
            );

            PasswordReset::where('reset_id', $reset_id)->delete();

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
