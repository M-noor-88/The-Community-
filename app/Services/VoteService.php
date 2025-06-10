<?php

namespace App\Services;

use App\Jobs\SendUserNotificationJob;
use App\Models\Project;
use App\Repositories\RecommendationRepository;
use App\Repositories\VoteRepository;
use App\Services\Notifications\UserNotificationService;
use Exception;
use Illuminate\Support\Facades\Auth;

class VoteService
{
    protected VoteRepository $voteRepository;

    protected RecommendationRepository $recommendRepo;

    protected UserNotificationService $notificationService;
    public function __construct(
        VoteRepository $voteRepository,
        RecommendationRepository $recommendRepo,
        UserNotificationService $notificationService
    )
    {
        $this->voteRepository = $voteRepository;
        $this->recommendRepo = $recommendRepo;
        $this->notificationService = $notificationService;
    }

    /**
     * @throws Exception
     */
    public function voteOnProject($projectId, $value): void
    {
        $project = Project::find($projectId);
        $userId = Auth::id();
        if (! $project) {
            throw new Exception('المشروع غير موجود');
        }

        if ($project->type !== 'مبادرة') {
            throw new Exception('التصويت متاح فقط في المبادرات');
        }

        $this->recommendRepo->updateInterests($project->category->id, $userId, 2);

        $this->voteRepository->storeVote($userId, $projectId, $value);

        //  Notify project owner
        $owner = $project->user;

        if ($owner && $owner->device_token) {
            $title = 'تم التصويت على مشروعك';
            $body = 'قام شخص ما بالتصويت على المبادرة: ' . $project->title;

            SendUserNotificationJob::dispatch(
                $owner->id,
                $owner->device_token,
                $title,
                $body,
            );
        }
    }
}
