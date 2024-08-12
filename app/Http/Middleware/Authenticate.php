<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware {
    /**
     * @inheritDoc
     */
    protected $auth;

    /**
     * @inheritDoc
     */
    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    /**
     * @inheritDoc
     */
    public function handle($request, \Closure $next, ...$guards) {
        if (
            (!$token = $request->bearerToken()) ||
            (!$user = User::query()->where('api_token', $token)->first())
        ) {
            return $this->unauthorized();
        }

        auth()->login($user);

        return $next($request);
    }

    public function unauthorized(): JsonResponse {
        return response()->json(['message' => 'Unauthorized.'], 401);
    }
}
