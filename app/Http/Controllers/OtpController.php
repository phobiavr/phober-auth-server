<?php

namespace App\Http\Controllers;

use App\Http\Requests\Otp\CheckSubmittedRequest;
use App\Http\Requests\Otp\GenerateRequest;
use App\Http\Requests\Otp\ValidateRequest;
use App\Services\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseFoundation;

class OtpController extends BaseController {
    public function __construct(private readonly OtpService $service) {
    }

    public function generateOtp(GenerateRequest $request): JsonResponse {
        $result = $this->service->generate($request->digits(), $request->validity());

        if (!$result['notified']) {
            return Response::json([
                'identifier' => $result['identifier'],
                'message'    => 'OTP created successfully, but failed to send',
            ], ResponseFoundation::HTTP_ACCEPTED);
        }

        return Response::json([
            'identifier' => $result['identifier'],
            'message'    => 'OTP created successfully',
        ]);
    }

    public function validateOtp(ValidateRequest $request): JsonResponse {
        if (!$this->service->validateCode($request->identifier(), $request->code())) {
            return Response::json(['message' => 'OTP is invalid'], ResponseFoundation::HTTP_BAD_REQUEST);
        }

        return Response::json(['message' => 'OTP validated successfully']);
    }

    public function submitOtp(ValidateRequest $request): JsonResponse {
        if (!$this->service->submitCode($request->identifier(), $request->code())) {
            return Response::json(['message' => 'OTP is invalid'], ResponseFoundation::HTTP_BAD_REQUEST);
        }

        return Response::json(['message' => 'OTP submitted successfully']);
    }

    public function checkSubmitted(CheckSubmittedRequest $request): JsonResponse {
        if (!$this->service->isSubmitted($request->identifier())) {
            return Response::json(['message' => 'OTP is not submitted'], ResponseFoundation::HTTP_BAD_REQUEST);
        }

        return Response::json(['message' => 'OTP validated successfully']);
    }
}
