<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService {
    public function authenticate(string $email, string $password): ?string {
        $user = User::query()->where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        // Str::random() is CSPRNG-backed (random_bytes); avoid mt_rand-based
        // generators (e.g. str_shuffle) here, their state can be recovered from output.
        $token = base64_encode(Str::random(40));

        $user->api_token = $token;
        $user->save();

        return $token;
    }
}
