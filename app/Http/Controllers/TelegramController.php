<?php

namespace App\Http\Controllers;

use App\Http\Requests\Telegram\LinkRequest;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\Response as ResponseFoundation;

class TelegramController extends BaseController {
    public function __construct(private readonly TelegramService $service) {
    }

    public function qrCodeForLink(Request $request): ResponseFoundation {
        /** @var User $user */
        $user = $request->user();

        if ($user->telegram) {
            return Response::json(
                ['message' => 'Telegram already linked to this account.'],
                ResponseFoundation::HTTP_CONFLICT,
            );
        }

        $link = $this->service->startLink($user);

        return Response::make(QrCode::size(300)->generate($link))
            ->header('Content-Type', 'image/svg+xml');
    }

    public function linkTelegram(LinkRequest $request): ResponseFoundation {
        $linked = $this->service->completeLink(
            $request->userId(),
            $request->token(),
            $request->username(),
            $request->chatId(),
        );

        if (!$linked) {
            return Response::json(status: ResponseFoundation::HTTP_BAD_REQUEST);
        }

        return Response::json();
    }
}
