<?php

namespace App\Http\Requests\Otp;

use Illuminate\Foundation\Http\FormRequest;

class ValidateRequest extends FormRequest {
    public function rules(): array {
        return [
            'identifier' => ['required', 'string'],
            'code'       => ['required', 'string'],
        ];
    }

    protected function prepareForValidation(): void {
        if ($this->has('code')) {
            $this->merge(['code' => strtoupper((string) $this->input('code'))]);
        }
    }

    public function identifier(): string {
        return $this->input('identifier');
    }

    public function code(): string {
        return $this->input('code');
    }
}
