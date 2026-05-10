<?php

use Illuminate\Support\Facades\Broadcast;

// Public dashboard channel — anything UI-wide
// (фронт: echo.channel('instances'))
// Если позже захотим закрыть — заменить на Broadcast::channel('instances', fn($user) => $user !== null)

Broadcast::channel('user.{userId}.notification', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
