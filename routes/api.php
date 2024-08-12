<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/authenticate', [AuthController::class, 'authenticate']);

Route::middleware('auth')->group(function () {
    Route::get('/valid', [AuthController::class, 'valid']);
});
