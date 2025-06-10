<?php

namespace App\Services\Notifications;

use Google\Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class UserNotificationService
{
    protected FirebaseNotificationService $firebaseService;
    protected NotificationStorageService $storageService;

    public function __construct(
        FirebaseNotificationService $firebaseService,
        NotificationStorageService $storageService
    ) {
        $this->firebaseService = $firebaseService;
        $this->storageService = $storageService;
    }

    /**
     * Send to one user
     */
    public function notifyUser(string $fcmToken, int $userId, string $title, string $body): void
    {
        try {
            $this->firebaseService->sendNotification($fcmToken, $title, $body);
            $this->storageService->store($userId, $title, $body);

        } catch (Exception|ConnectionException $e) {
            Log::error("Notification failed for user $userId: " . $e->getMessage());
        }
    }

    /**
     * Send to multiple users
     * @param array<int, string> $usersWithTokens key=user_id, value=fcm_token
     */
    public function notifyMultipleUsers(array $usersWithTokens, string $title, string $body): void
    {
        foreach ($usersWithTokens as $userId => $fcmToken) {
            try {
                $this->firebaseService->sendNotification($fcmToken, $title, $body);
                $this->storageService->store($userId, $title, $body);
            } catch (\Throwable $e) {
                Log::error("Notification failed for user $userId: " . $e->getMessage());
            }
        }
    }
}
