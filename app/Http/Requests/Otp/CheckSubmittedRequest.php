<?php

namespace App\Http\Requests\Otp;

use Illuminate\Foundation\Http\FormRequest;
use Phobiavr\PhoberLaravelCommon\Data\CheckSubmittedPayload;

class CheckSubmittedRequest extends FormRequest {
    public function rules(): array {
        return [
            'identifier' => ['required', 'string'],
        ];
    }

    public function payload(): CheckSubmittedPayload {
        return CheckSubmittedPayload::fromArray($this->validated());
    }
}
