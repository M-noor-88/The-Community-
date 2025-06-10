<?php

namespace App\Services\Notifications;

use App\Models\Notification;

class NotificationStorageService
{
    public function store(int $userId, string $title, string $body): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'body' => $body,
        ]);
    }
}
