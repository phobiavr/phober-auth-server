<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Phobiavr\PhoberLaravelCommon\Clients\NotificationClient;
use Phobiavr\PhoberLaravelCommon\Enums\NotificationProvider;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\Response;

class TelegramController extends BaseController
{
    public const CACHE_PREFIX = 'auth_telegram_link_token_';

    public function qrCodeForLink(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->telegram) {
            return response()->json(['message' => 'Telegram already linked to this account.'], Response::HTTP_CONFLICT);
        }

        $token = Str::random(5);

        Cache::put(self::CACHE_PREFIX . $user->id, $token, 120);

        $payload = [
            'server' => 'auth',
            'action' => 'link',
            'id' => $user->id,
            'token' => $token,
        ];

        $link = NotificationClient::generateShortLinkForTelegram($payload);

        return response(QrCode::size(300)->generate($link))->header('Content-Type', 'image/svg+xml');
    }

    public function linkTelegram(Request $request): Response
    {
        $user = \App\Models\User::findOrFail($request->user_id);
        $cacheKey = TelegramController::CACHE_PREFIX . $request->user_id;
        $token = Cache::get($cacheKey);

        if ($user && (($token ?? '') === $request->token)) {
            $user->telegram = $request->username;
            $user->telegram_chat_id = $request->chat_id;
            $user->save();

            Cache::forget($cacheKey);
            
            $message = "Hi, " . $user->first_name . " " . $user->last_name . "!\nYour telegram linked to your account!";

            NotificationClient::sendMessage(NotificationProvider::TELEGRAM, $request->chat_id, $message);

            return response()->json();
        }

        return response()->json(status: Response::HTTP_BAD_REQUEST);
    }
}
