<?php

namespace App\Services;

use Abdukhaligov\LaravelOTP\OtpFacade as Otp;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Phobiavr\PhoberLaravelCommon\Clients\NotificationClient;
use Phobiavr\PhoberLaravelCommon\Enums\NotificationChannel;
use Phobiavr\PhoberLaravelCommon\Enums\NotificationProvider;
use Phobiavr\PhoberLaravelCommon\Helper;

class OtpService {
    /**
     * @return array{identifier: string, notified: bool}
     */
    public function generate(int $digits, int $validity): array {
        $identifier = Helper::quickRandom(15);
        $code       = Otp::generate($identifier, $digits, $validity, onlyDigits: true);
        $notified   = true;

        try {
            NotificationClient::sendMessage(
                NotificationProvider::TELEGRAM,
                NotificationChannel::OTP,
                'OTP: ' . $code,
            );
        } catch (\Exception|ConnectionException $e) {
            Log::error('Failed to send OTP notification', ['message' => $e->getMessage()]);
            $notified = false;
        }

        return ['identifier' => $identifier, 'notified' => $notified];
    }

    public function validateCode(string $identifier, string $code): bool {
        return (bool) Otp::validate($identifier, $code);
    }

    public function submitCode(string $identifier, string $code): bool {
        return (bool) Otp::submit($identifier, $code);
    }

    public function isSubmitted(string $identifier): bool {
        return (bool) Otp::checkSubmitted($identifier);
    }
}
