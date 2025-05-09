<?php

namespace App\Repositories;

use App\Models\CampaignParticipant;
use App\Models\Project;
use Exception;

class CampaignParticipantRepository
{
    /**
     * @throws Exception
     */
    public function createJoinParticipantWithStatus($projectId, $userId, $status)
    {
        $existingJoined = CampaignParticipant::where('user_id', $userId)->where('project_id', $projectId)->first();

        if ($existingJoined) {
            throw new Exception('لقد قمت بالانضمام بالفعل');
        }

        return CampaignParticipant::create([
            'user_id' => $userId,
            'project_id' => $projectId,
            'status' => $status,
        ]);
    }

    public function getPendingJoinsForVolunteerAdmin($adminId)
    {
        return CampaignParticipant::where('status', 'انتظار')
            ->whereHas('project', function ($query) use ($adminId) {
                $query->where('user_id', $adminId);
            })
            ->with(['user', 'project'])
            ->get();
    }

    /**
     * @throws Exception
     */
    public function UpdateStatusParticipant($participantId, $adminId, $status)
    {
        $participant = CampaignParticipant::where('id', $participantId)
            ->whereHas('project', function ($query) use ($adminId) {
                $query->where('user_id', $adminId);
            })
            ->first();

        if (! $participant) {
            throw new Exception('لا يوجد طلب انضمام بهذا المعرف أو ليس لديك صلاحية');
        }

        $participant->status = $status;
        $participant->save();

        return $participant;
    }

    public function getProjectsUserJoined($userId)
    {
        return Project::whereHas('participants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with(['category', 'location', 'image', 'ratings.user', 'user'])
            ->latest()
            ->get();
    }
}
