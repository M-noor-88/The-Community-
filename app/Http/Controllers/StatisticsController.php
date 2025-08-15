<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;
use App\Repositories\StatisticsRepository;
use App\Traits\JsonResponseTrait;
use Exception;

class StatisticsController extends Controller
{
    use JsonResponseTrait;
    public function __construct(protected StatisticsService $statisticsService,protected StatisticsRepository $statistics_repository) {}

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

    // public function projectsByLocation(): JsonResponse
    // {
    //     return $this->makeResponse('Projects by location fetched successfully', $this->statisticsService->getProjectsByLocation());
    // }

     public function complaintsByLocation(): JsonResponse
     {
         return $this->makeResponse('Complaints by location fetched successfully', $this->statisticsService->getComplaintStatisticsWithLocations());
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

    public function getLowEngagementCampaigns(): JsonResponse
    {
        $data = $this->statisticsService->getLowEngagementCampaignsWithActions();

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Low engagement campaigns fetched successfully'
        ]);
    }


    public function promoteCampaign(int $id): JsonResponse
    {
        try {
            $campaign = Project::findOrFail($id);

            $campaign->update([
                'is_promoted' => true,
                'is_archived' => false,
            ]);
            $campaign->save();

            return response()->json(['message' => 'Campaign promoted successfully']);

        }catch (\Exception $e)
        {
            return response()->json(['message' => 'Failed '. $e->getMessage()]);
        }

    }

    public function archiveCampaign(int $id): JsonResponse
    {
        try {
            $campaign = Project::findOrFail($id);

            $campaign->update([
                'is_archived' => true,
                'is_promoted' => false,
            ]);

            return response()->json(['message' => 'Campaign archived successfully']);
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Failed '. $e->getMessage()]);
        }
    }



    ////////////////complaints/////////////////////

    public function getComplaintStatistics()
    {

        try {
            $complaintsStatistics = $this->statisticsService->getComplaintStatistics();

            return $this->success($complaintsStatistics, 'Categories retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

    }

    public function getPaymentStatistics()
    {
        try {
            $paymentStatistics = $this->statisticsService->getPaymentStatistics();
            return $this->success($paymentStatistics, 'Categories retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getPointSystemStatistics()
    {
        try {
            $pointSystemStatistics = $this->statisticsService->getPointSystemStatistics();
            return $this->success($pointSystemStatistics, 'Categories retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getMostRepeatedComplaint()
    {
        try {
            $mostRepeatedComplaint = $this->statisticsService->getMostRepeatedComplaint();
            return $this->success($mostRepeatedComplaint, 'Most repeated complaint retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

     public function bestDay()
    {
        try {
            return $this->success($this->statisticsService->getBestCampaignDay(), 'Best day to publish campaign');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function mostComplaintsRegion()
    {
        try {
            return $this->success($this->statisticsService->getMostComplaintsRegion(), 'Most complaints region retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function LessComplaintsRegion()
    {
        try{
            return $this->success($this->statisticsService->getLessComplaintRegion(), 'Less complaint region retrieved successfully');
        }catch (Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function mostCampaignDonation()
    {
        try{
            return $this->success($this->statisticsService->getMostCampaignDonation(), 'Most campaign donation retrieved successfully');
        }catch (Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function mostCampaignParticipate()
    {
        try{
            return $this->success($this->statisticsService->getMostCampaignParticipate(), 'Most campaign participate retrieved successfully');
        }catch (Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function averageExcecutionComplaint()
    {
        try{
            return $this->success($this->statisticsService->getAverageExcecutionComplaint(), 'Average excecution time for complaints ');
        }catch (Exception $e){
            return $this->error($e->getMessage());
        }
    }
}
