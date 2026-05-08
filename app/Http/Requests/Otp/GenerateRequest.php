<?php

namespace App\Http\Requests\Otp;

use Illuminate\Foundation\Http\FormRequest;

class GenerateRequest extends FormRequest {
    public function rules(): array {
        return [
            'digits'   => ['required', 'integer', 'min:1'],
            'validity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function digits(): int {
        return (int) $this->input('digits');
    }

    public function validity(): int {
        return (int) $this->input('validity');
    }
}
