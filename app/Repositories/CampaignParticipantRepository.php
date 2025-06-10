<?php

namespace App\Repositories;

use App\Jobs\SendUserNotificationJob;
use App\Models\CampaignParticipant;
use App\Models\Project;
use App\Models\User;
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

        // ✅ Notify the user who applied
        $user = User::find($participant->user_id);
        $project = $participant->project;

        if ($user && $user->device_token) {
            $title = 'تحديث على طلب انضمامك للحملة';
            $body = $status === 'تمت الموافقة'
                ? "تمت الموافقة على طلب انضمامك إلى الحملة: {$project->title}"
                : "تم رفض طلب انضمامك إلى الحملة: {$project->title}";

            SendUserNotificationJob::dispatch(
                $user->id,
                $user->device_token,
                $title,
                $body
            );
        }

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
