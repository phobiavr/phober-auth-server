<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Phobiavr\PhoberLaravelCommon\Clients\NotificationClient;
use Phobiavr\PhoberLaravelCommon\Enums\NotificationProvider;

class TelegramService {
    public const CACHE_PREFIX = 'auth_telegram_link_token_';
    private const TOKEN_TTL_SECONDS = 120;

    public function startLink(User $user): string {
        $token = Str::random(5);

        Cache::put(self::CACHE_PREFIX . $user->id, $token, self::TOKEN_TTL_SECONDS);

        return NotificationClient::generateShortLinkForTelegram([
            'server' => 'auth',
            'action' => 'link',
            'id'     => $user->id,
            'token'  => $token,
        ]);
    }

    public function completeLink(int $userId, string $token, string $username, mixed $chatId): bool {
        $user     = User::find($userId);
        $cacheKey = self::CACHE_PREFIX . $userId;
        $expected = Cache::get($cacheKey);

        if (!$user || ($expected ?? '') !== $token) {
            return false;
        }

        $user->telegram         = $username;
        $user->telegram_chat_id = $chatId;
        $user->save();

        Cache::forget($cacheKey);

        $message = "Hi, {$user->first_name} {$user->last_name}!\nYour telegram linked to your account!";

        NotificationClient::sendMessage(NotificationProvider::TELEGRAM, $chatId, $message);

        return true;
    }
}
