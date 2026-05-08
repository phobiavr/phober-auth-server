<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateRequest extends FormRequest {
    public function rules(): array {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function email(): string {
        return $this->input('email');
    }

    public function password(): string {
        return $this->input('password');
    }
}
