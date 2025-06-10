<?php

namespace App\Jobs;

use App\Services\Notifications\UserNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendUserNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $userId,
        public string $device_token,
        public string $title,
        public string $body,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(UserNotificationService $notificationService): void
    {
        $notificationService->notifyUser($this->device_token, $this->userId ,  $this->title, $this->body);
    }
}
