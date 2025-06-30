<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;

Route::post('/authenticate', [AuthController::class, 'authenticate']);

Route::middleware('auth')->group(function () {
    Route::get('/valid', [AuthController::class, 'valid']);
    Route::get('/link/telegram', [TelegramController::class, 'qrCodeForLink']);
});

Route::middleware('private')->group(function () {
    Route::post('/link/telegram', [TelegramController::class, 'linkTelegram']);
});

Route::prefix('/otp')->group(function () {
    Route::post('/generate', [OtpController::class, 'generateOtp']);
    Route::post('/validate', [OtpController::class, 'validateOtp']);
    Route::get('/submit', [OtpController::class, 'submitOtp']);
    Route::post('/check-submitted', [OtpController::class, 'checkSubmitted']);
});