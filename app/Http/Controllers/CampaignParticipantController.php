<?php

namespace App\Http\Controllers;

use App\Services\CampaignParticipantService;
use App\Services\ProjectService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampaignParticipantController extends Controller
{
    use JsonResponseTrait;

    public function __construct(
        protected CampaignParticipantService $joinCampaignPartService,
        protected ProjectService $projectService,
    ) {}

    public function joinToProject($projectId): JsonResponse
    {
        try {
            $data = $this->joinCampaignPartService->joinToProject($projectId);

            return $this->success($data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

    }

    public function getPendingJoins(): JsonResponse
    {
        try {
            $data = $this->joinCampaignPartService->getPendingJoinsForMyCampaigns();

            return $this->success($data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function approveJoinRequest($participantId, Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:تمت الموافقة,تم الرفض',
        ]);

        try {
            $data = $this->joinCampaignPartService->updateJoinRequest($participantId, $request->status);

            return $this->success($data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function myJoinedProjects(): JsonResponse
    {
        try {
            $data = $this->projectService->getProjectsUserJoined();

            return $this->success($data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
