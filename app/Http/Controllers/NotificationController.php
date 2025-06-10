<?php

namespace App\Http\Controllers;

use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\NotificationService;


class NotificationController extends Controller
{
    use JsonResponseTrait;
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(): JsonResponse
    {
        try {
            $notifications = $this->notificationService->getUserNotifications();

            return $this->success($notifications , "true");
        }
        catch (\Exception $e)
        {
            return $this->error("Failed get Notifications ". $e->getMessage());
        }

    }
}
