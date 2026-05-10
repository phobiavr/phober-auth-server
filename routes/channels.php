<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('instances', function ($user) {
    return $user !== null;
});

Broadcast::channel('user.{userId}.notification', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
