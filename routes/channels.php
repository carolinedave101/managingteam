<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', fn ($user, $id) => (int) $user->id === (int) $id);

Broadcast::channel('celebrity.{celebrityId}.fan.{userId}', function (User $user, int $celebrityId, int $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('celebrity.{celebrityId}.admin', function (User $user, int $celebrityId) {
    return $user->isAdmin();
});

Broadcast::channel('admin.global', function (User $user) {
    return $user->isAdmin();
});
