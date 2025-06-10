<?php

namespace App\Services;

use App\Jobs\SendUserNotificationJob;
use App\Models\User;
use App\Repositories\ProjectRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProjectPromotionService
{
    public function __construct(protected ProjectRepository $projectRepo) {}

    public function listInitiativesSorted()
    {
        $topInitiatives = $this->projectRepo->getTopInitiatives();

        return $topInitiatives->map(function ($initiative) {
            return $this->transformProject($initiative);
        });
    }

    /**
     * @throws Exception
     */
    public function assignAsCampaign(int $projectId, $executionDate, $status): array
    {
        $project = $this->projectRepo->get($projectId);

        $data = $this->projectRepo->promoteToOfficialCampaign($project, [
            'execution_date' => $executionDate,
            'status' => $status,
        ]);

        $owner = $project->user;

        if ($owner && $owner->device_token) {
            SendUserNotificationJob::dispatch(
                $owner->id,
                $owner->device_token,
                'تحديث حالة المشروع',
                "تمت تحديث  مشروعك '{$project->title}' إلى حملة {$status} ",
            );
        }

        return [
            'id' => $data['id'],
            'title' => $data['title'],
            'description' => $data->description,
            'status' => $data->status,
            'execution_date' => $data->Execution_date,
            'user' => [
                'id' => $data->user?->id,
                'created_by' => $data->user?->name,
                'role' => $data->user?->getRoleNames()[0],
            ],
            'image_url' => $data->image?->image_url,
            'category' => $data->category?->name,
            'location' => [
                'name' => $data->location?->name,
                'latitude' => $data->location?->latitude,
                'longitude' => $data->location?->longitude,
            ],
            'votes_count' => $data->votes?->count() ?? 0,
            'likes' => $data->totalVotes?->likes ?? 0,
            'dislikes' => $data->totalVotes?->dislikes ?? 0,
            'donation_total' => $data->donationSummary?->total_amount ?? 0,
            'number_of_participants' => $data->number_of_participant,
            'required_amount' => $data->donationSummary?->required_amount ?? 0,
        ];

    }

    /**
     * @throws Exception
     */
    public function assignAsCompleted(int $projectId, $executionDate, $status): array
    {

        $project = $this->projectRepo->get($projectId);
        // التاأكد من ان صاحب الحملة هو الفريق التطوعي وجعلها حملة منجزة
        $user = User::where('id', Auth::id())->first();
        if ($user->hasRole('volunteer_admin') && $project->user->id == $user->id) {
            $this->projectRepo->promoteToOfficialCampaign($project, [
                'execution_date' => $executionDate,
                'status' => $status,
            ]);

            return [
                'title' => $project->title,
                'status' => $project->status,
                'category' => $project->category?->name,

            ];
        } else {
            throw new Exception('ليس لديك الصلاحية');
        }
    }

    // تنظيم الريسبونس حسب نوع المشروع
    private function transformProject($project): array
    {
        return [
            'id' => $project->id,
            'title' => $project->title,
            'description' => $project->description,
            'status' => $project->status,
            'execution_date' => $project->Execution_date ?? null,
            'user' => [
                'id' => $project->user?->id,
                'created_by' => $project->user?->name,
                'role' => $project->user?->getRoleNames()[0],
            ],
            'image_url' => $project->image?->image_url,
            'category' => $project->category?->name,
            'location' => [
                'name' => $project->location?->name,
                'latitude' => $project->location?->latitude,
                'longitude' => $project->location?->longitude,
            ],
            'votes_count' => $project->votes?->count() ?? 0,
            'likes' => $project->totalVotes?->likes ?? 0,
            'dislikes' => $project->totalVotes?->dislikes ?? 0,
            'donation_total' => $project->donationSummary?->total_amount ?? 0,
            'number_of_participants' => $project->number_of_participant,
            'required_amount' => $project->donationSummary?->required_amount ?? 0,
        ];
    }
}
