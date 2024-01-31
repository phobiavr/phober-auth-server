<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate extends Middleware
{
    /**
     * @inheritDoc
     */
    protected $auth;

    /**
     * @inheritDoc
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @inheritDoc
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        $token = $request->bearerToken();
        $user  = User::query()->where('api_token', $token)->first();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        auth()->login($user);

        return $next($request);
    }
}
