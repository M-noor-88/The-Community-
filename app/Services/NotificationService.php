<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function getUserNotifications()
    {
        $user = User::findOrFail(Auth::id());

        return $user->notifications()
            ->latest()
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'body' => $notification->body,
                    'created_at' => $notification->created_at->diffForHumans(), // formatted
                ];
            });
    }
}
