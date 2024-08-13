<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController {
    public function authenticate(Request $request): JsonResponse {
        $user = User::query()->where('email', $request->input('email'))->first();

        if (Hash::check($request->input('password'), $user->password)) {
            $token = base64_encode(self::quickRandom(40));

            $user->api_token = $token;
            $user->save();

            return response()->json(['token' => "$token"]);
        } else {
            return response()->json(['message' => 'Credentials error'], 401);
        }
    }

    private static function quickRandom($length = 16): string {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function valid(Request $request): JsonResponse {
        $user = auth()->user();

        return response()->json(['user' => $user->toArray()]);
    }
}
