<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OtpController;
use Illuminate\Support\Facades\Route;

Route::post('/authenticate', [AuthController::class, 'authenticate']);

Route::middleware('auth')->group(function () {
    Route::get('/valid', [AuthController::class, 'valid']);
});

Route::prefix('/otp')->group(function () {
    Route::post('/generate', [OtpController::class, 'generateOtp']);
    Route::post('/validate', [OtpController::class, 'validateOtp']);
    Route::get('/submit', [OtpController::class, 'submitOtp']);
    Route::get('/check-submitted/{identifier}', [OtpController::class, 'checkSubmitted']);
});
