<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware {
    public function handle($request, \Closure $next, ...$guards) {
        if (
            (!$token = $request->bearerToken()) ||
            (!$user = User::query()->where('api_token', $token)->first())
        ) {
            return $this->unauthorized();
        }

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }

    public function unauthorized(): JsonResponse {
        return response()->json(['message' => 'Unauthorized.'], 401);
    }
}
