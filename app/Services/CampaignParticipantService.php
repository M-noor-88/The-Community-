<?php

namespace App\Services;

use App\Repositories\CampaignParticipantRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\RecommendationRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class CampaignParticipantService
{
    public function __construct(
        protected ProjectRepository $projectRepository,
        protected CampaignParticipantRepository $joinCampaignPartRepository,
        protected RecommendationRepository $recommendRepo,
    ) {}

    /**
     * @throws Exception
     */
    public function joinToProject($projectId)
    {
        $project = $this->projectRepository->get($projectId);

        $joinedCount = $project->participants()->where('status', 'تمت الموافقة')->count();
        $NoParticipantRequired = $project->number_of_participant;

        if (($joinedCount + 1) > $NoParticipantRequired) {
            throw new Exception('العدد المطلوب للحملة اكتمل! , شكرا لك');
        }

        if ($project->type != 'حملة رسمية' || $project->status != 'نشطة') {
            throw new Exception('المشروع ليس حملة رسمية نشطة بعد ! , يرجى الانتظار');
        }

        $ownerRole = $project->user?->getRoleNames()[0];
        $userID = Auth::id();
        $data = null;

        //        اذا كان مستخدم عادي اللي عمل انشاء للمشروع ثم اصبح حملة رسمية , المستخدمين بتقدر تنضم مباشرة
        if ($ownerRole == 'client') {
            $data = $this->joinCampaignPartRepository
                ->createJoinParticipantWithStatus(
                    $projectId, $userID, 'تمت الموافقة');
        } elseif ($ownerRole == 'volunteer_admin') {
            $data = $this->joinCampaignPartRepository
                ->createJoinParticipantWithStatus(
                    $projectId, $userID, 'انتظار');
        }

        $this->recommendRepo->updateInterests($project->category->id , $userID , 3);

        return $data;
    }

    /**
     * @throws Exception
     */
    public function getPendingJoinsForMyCampaigns()
    {
        $adminId = Auth::id();

        if (! Auth::user()->hasRole('volunteer_admin')) {
            throw new Exception('ليس لديك صلاحية');
        }
        $pendingJoins = $this->joinCampaignPartRepository->getPendingJoinsForVolunteerAdmin($adminId);

        return $pendingJoins->map(function ($join) {
            return [
                'id' => $join->id,
                'user_id' => $join->user_id,
                'project_id' => $join->project_id,
                'status' => $join->status,
                'user_name' => $join->user?->name,
                'project_title' => $join->project?->title,
            ];
        });
    }

    /**
     * @throws Exception
     */
    public function updateJoinRequest($participantId, $status)
    {
        $adminId = Auth::id();

        if (! Auth::user()->hasRole('volunteer_admin')) {
            throw new Exception('ليس لديك صلاحية');
        }

        return $this->joinCampaignPartRepository->UpdateStatusParticipant($participantId, $adminId, $status);
    }
}
