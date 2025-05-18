<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function __construct(protected StatisticsService $statisticsService) {}

    public function weeklyParticipation(): JsonResponse
    {
        $data = $this->statisticsService->getWeeklyParticipation();

        return response()->json([
            'status' => true,
            'message' => 'Weekly participation data retrieved successfully.',
            'data' => $data,
        ]);
    }

    public function basicCounts(): JsonResponse
    {
        return $this->makeResponse('Basic counts fetched successfully', $this->statisticsService->getBasicCounts());
    }

    public function topRatedProjects(): JsonResponse
    {
        return $this->makeResponse('Top-rated projects fetched successfully', $this->statisticsService->getTopRatedProjects());
    }

    public function mostParticipatedProjects(): JsonResponse
    {
        return $this->makeResponse('Most participated projects fetched successfully', $this->statisticsService->getMostParticipatedProjects());
    }

    public function projectsByCategory(): JsonResponse
    {
        return $this->makeResponse('Projects by category fetched successfully', $this->statisticsService->getProjectsByCategory());
    }

    public function votesSummary(): JsonResponse
    {
        return $this->makeResponse('Votes summary fetched successfully', $this->statisticsService->getVotesSummary());
    }

    public function projectsByLocation(): JsonResponse
    {
        return $this->makeResponse('Projects by location fetched successfully', $this->statisticsService->getProjectsByLocation());
    }

    public function complaintsByLocation(): JsonResponse
    {
        return $this->makeResponse('Complaints by location fetched successfully', $this->statisticsService->getComplaintsByLocation());
    }

    public function userRoleDistribution(): JsonResponse
    {
        return $this->makeResponse('User role distribution fetched successfully', $this->statisticsService->getUserRoleDistribution());
    }

    public function getOfficialCampaigns()
    {
        return response()->json([
            'success' => true,
            'message' => 'Official campaigns statistics fetched successfully',
            'data' => $this->statisticsService->getOfficialCampaigns(),
        ]);
    }

    public function getInitiatives()
    {
        return response()->json([
            'success' => true,
            'message' => 'Initiative statistics fetched successfully',
            'data' => $this->statisticsService->getInitiativeProjects(),
        ]);
    }

    public function getComplaintStats()
    {
        return response()->json([
            'success' => true,
            'message' => 'Complaint statistics fetched successfully',
            'data' => $this->statisticsService->getComplaintStatistics(),
        ]);
    }

    protected function makeResponse(string $message, $data): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function getMonthlyStatistics()
    {
        return response()->json([
            'success' => true,
            'message' => 'Monthly statistics fetched successfully',
            'data' => $this->statisticsService->getMonthlyStatistics(),
        ]);
    }

    public function getNumberProjectsStatus()
    {
        return response()->json([
            'success' => true,
            'message' => 'Monthly statistics fetched successfully',
            'data' => $this->statisticsService->getNumberStatusProjects(),
        ]);
    }
}
