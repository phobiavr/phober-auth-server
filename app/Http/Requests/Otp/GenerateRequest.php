<?php

namespace App\Http\Requests\Otp;

use Illuminate\Foundation\Http\FormRequest;
use Phobiavr\PhoberLaravelCommon\Data\GenerateOtpPayload;

class GenerateRequest extends FormRequest {
    public function rules(): array {
        return [
            'digits'   => ['required', 'integer', 'min:1'],
            'validity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function payload(): GenerateOtpPayload {
        return GenerateOtpPayload::fromArray($this->validated());
    }
}
