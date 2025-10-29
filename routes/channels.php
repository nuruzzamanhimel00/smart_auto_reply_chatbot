<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('order-notify.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
