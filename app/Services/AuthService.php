<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Phobiavr\PhoberLaravelCommon\Helper;

class AuthService {
    public function authenticate(string $email, string $password): ?string {
        $user = User::query()->where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        $token = base64_encode(Helper::quickRandom(40));

        $user->api_token = $token;
        $user->save();

        return $token;
    }
}
