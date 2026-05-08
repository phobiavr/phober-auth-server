<?php

namespace App\Http\Requests\Telegram;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id'  => ['required', 'integer'],
            'token'    => ['required', 'string'],
            'username' => ['required', 'string'],
            'chat_id'  => ['required'],
        ];
    }

    public function userId(): int {
        return (int) $this->input('user_id');
    }

    public function token(): string {
        return $this->input('token');
    }

    public function username(): string {
        return $this->input('username');
    }

    public function chatId(): mixed {
        return $this->input('chat_id');
    }
}
