<?php

namespace App\Http\Controllers;

use Abdukhaligov\LaravelOTP\OtpFacade as Otp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class OtpController extends BaseController {
    public function generateOtp(Request $request): JsonResponse {
        $identifier = $request->get('identifier');
        $digits = $request->get('digits');
        $validity = $request->get('validity');

        $code = Otp::generate($identifier, $digits, $validity, onlyDigits: true);

        return response()->json(['code' => $code]);
    }

    public function validateOtp(Request $request): JsonResponse {
        $identifier = $request->get('identifier');
        $code = strtoupper($request->get('code'));

        $valid = Otp::validate($identifier, $code);

        if (!$valid) {
            return response()->json(['message' => 'OTP is invalid'], 400);
        }

        return response()->json(['message' => 'OTP validated successfully']);
    }

    public function submitOtp(Request $request): JsonResponse {
        $identifier = $request->get('identifier');
        $code = strtoupper($request->get('code'));

        $valid = Otp::submit($identifier, $code);

        if (!$valid) {
            return response()->json(['message' => 'OTP is invalid'], 400);
        }

        return response()->json(['message' => 'OTP submitted successfully']);
    }

    public function checkSubmitted(Request $request): JsonResponse {
        $identifier = $request->get('identifier');
        $valid = Otp::checkSubmitted($identifier);

        if (!$valid) {
            return response()->json(['message' => 'OTP is not submitted'], 400);
        }

        return response()->json(['message' => 'OTP validated successfully']);
    }
}
