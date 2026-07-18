<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthenticateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseFoundation;

class AuthController extends BaseController {
    public function __construct(private readonly AuthService $service) {
    }

    public function authenticate(AuthenticateRequest $request): JsonResponse {
        $token = $this->service->authenticate($request->email(), $request->password());

        if (!$token) {
            return Response::json(['message' => 'Credentials error'], ResponseFoundation::HTTP_UNAUTHORIZED);
        }

        return Response::json(['token' => $token]);
    }

    public function valid(): JsonResponse {
        return Response::json(['user' => UserResource::make(auth()->user())]);
    }

    public function show(int $id): JsonResponse {
        $user = User::find($id);

        if (!$user) {
            return Response::json(['message' => 'Not Found'], ResponseFoundation::HTTP_NOT_FOUND);
        }

        return Response::json(['user' => UserResource::make($user)]);
    }
}
