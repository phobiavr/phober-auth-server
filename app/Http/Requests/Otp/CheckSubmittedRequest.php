<?php

namespace App\Http\Requests\Otp;

use Illuminate\Foundation\Http\FormRequest;

class CheckSubmittedRequest extends FormRequest {
    public function rules(): array {
        return [
            'identifier' => ['required', 'string'],
        ];
    }

    public function identifier(): string {
        return $this->input('identifier');
    }
}
