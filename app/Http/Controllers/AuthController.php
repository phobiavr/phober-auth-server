<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Phobiavr\PhoberLaravelCommon\Helper;

class AuthController extends BaseController {
    public function authenticate(AuthenticateRequest $request): JsonResponse {
        $user = User::query()->where('email', $request->input('email'))->first();

        if (Hash::check($request->input('password'), $user->password)) {
            $token = base64_encode(Helper::quickRandom(40));

            $user->api_token = $token;
            $user->save();

            return response()->json(['token' => "$token"]);
        } else {
            return response()->json(['message' => 'Credentials error'], 401);
        }
    }

    public function valid(Request $request): JsonResponse {
        $user = auth()->user();

        return response()->json(['user' => $user->toArray()]);
    }
}
