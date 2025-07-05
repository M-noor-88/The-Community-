<?php

namespace App\Services;

use App\Models\CampaignParticipant;
use App\Repositories\StatisticsRepository;
use Illuminate\Database\Eloquent\Collection;

class StatisticsService
{
    public function __construct(protected StatisticsRepository $statisticsRepo) {}

    public function getBasicCounts(): array
    {
        return $this->statisticsRepo->getBasicCounts();
    }

    public function getTopRatedProjects(): array
    {
        return $this->statisticsRepo->getTopRatedProjects()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'type' => $project->type,
                    'status' => $project->status,
                    'average_rating' => (float) $project->ratings_avg_rating,
                    'participant_count' => $project->number_of_participant,
                    'created_by' => $project->user->name ?? null,
                    'category' => $project->category->name ?? null,
                    'location' => $project->location->name ?? null,
                    'image_url' => $project->image->image_url ?? null,
                ];
            })->toArray();
    }

    public function getMostParticipatedProjects(): array
    {
        return $this->statisticsRepo->getMostParticipatedProjects()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'type' => $project->type,
                    'status' => $project->status,
                    'participant_count' => $project->participants->count(),
                    'average_rating' => (float) $project->ratings_avg_rating,
                    'created_by' => $project->user->name ?? null,
                    'category' => $project->category->name ?? null,
                    'location' => $project->location->name ?? null,
                    'image_url' => $project->image->image_url ?? null,
                ];
            })->toArray();
    }

    public function getProjectsByCategory(): array
    {
        return $this->statisticsRepo->getProjectCountByCategory()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'projects_count' => $category->projects_count,
                ];
            })->toArray();
    }

    public function getVotesSummary()
    {
        return $this->statisticsRepo->getVotesSummary();
    }

    public function getUserRoleDistribution(): array
    {
        return $this->statisticsRepo->getUserRoleDistribution();
    }

    public function getWeeklyParticipation(): Collection
    {
        return CampaignParticipant::selectRaw('WEEK(created_at) as week, COUNT(*) as count')
            ->groupBy('week')
            ->orderBy('week')
            ->get();
    }

    // حملات رسمية
    public function getOfficialCampaigns(): array
    {
        return $this->statisticsRepo->getOfficialCampaignsWithLocation()
            ->map(function ($project) {
                return [
                    'title' => $project->title,
                    'type' => $project->type,
                    'latitude' => $project->location?->latitude,
                    'longitude' => $project->location?->longitude,
                ];
            })->toArray();
    }

    // مبادرات
    public function getInitiativeProjects(): array
    {
        return $this->statisticsRepo->getInitiativesWithLocation()
            ->map(function ($project) {
                return [
                    'title' => $project->title,
                    'type' => $project->type,
                    'latitude' => $project->location?->latitude,
                    'longitude' => $project->location?->longitude,
                ];
            })->toArray();
    }

    // Complaints
    public function getComplaintStatisticsWithLocations(): array
    {
        return $this->statisticsRepo->getComplaintsWithLocationAndCategory()
            ->map(function ($complaint) {
                return [
                    'title' => $complaint->title,
                    'category' => $complaint->category?->name,
                    'latitude' => $complaint->location?->latitude,
                    'longitude' => $complaint->location?->longitude,
                ];
            })->toArray();
    }


    public function getMonthlyStatistics(): array
    {
        return $this->statisticsRepo->getMonthlyCounts()->toArray();
    }

    public function getNumberStatusProjects()
    {
        return $this->statisticsRepo->getNumberStatusProjects();
    }

    public function getLowEngagementCampaignsWithActions(): array
    {
        $campaigns = $this->statisticsRepo->getLowEngagementCampaigns();

        return $campaigns->map(function ($campaign) {
            $suggestedAction = 'archive';

            if ($campaign->participants_count > 0 || $campaign->donationSummary?->total_donors > 0) {
                $suggestedAction = 'promote';
            }

            return [
                'id' => $campaign->id,
                'title' => $campaign->title,
                'created_at' => $campaign->created_at->format('Y-m-d'),
                'joined_participants' => $campaign->participants_count?? 0,
                'total_donations' => $campaign->donationSummary?->total_donors ?? 0,
                'suggested_action' => $suggestedAction,
                'status' => $campaign->status,
                'creator' => [
                    'name' => $campaign->user->name ?? null,
                    'email' => $campaign->user->email ?? null,
                ],
            ];
        })->toArray();
    }
    // Complaints
    public function getComplaintStatistics(): array
    {

        // 1. Complaints by Status
        $statusCounts = $this->statisticsRepo->getComplaintByStatus();


        // 2. Time to Resolve (only for 'انتظار' and 'يتم التنفيذ')
        $pendingTime = $this->statisticsRepo->PendingTime();


        $inProgressTime = $this->statisticsRepo->InProgressTime();


        // 3. Total Complaints
        $totalComplaints = $this->statisticsRepo->getTotalComplaints();

        // 4. Complaints by Category
        $categoryCounts = $this->statisticsRepo->getComplaintsByCategory();


        return [
            'status_counts' => $statusCounts,
            'avg_resolution_time_hours' => [
                'pending' => round($pendingTime ?? 0, 1),
                'in_progress' => round($inProgressTime ?? 0, 1),
            ],
            'total_complaints' => $totalComplaints,
            'complaints_by_category' => $categoryCounts,
        ];
    }

    public function getPaymentStatistics(): array
    {
        // 1. Most Payment (Highest single successful donation)
        $mostPayment = $this->statisticsRepo->getMostPayment();


        // 2. Total Payment (sum of all successful donations)
        $totalPayment = $this->statisticsRepo->getTotalPayment();

        // 3. Top 5 Campaigns by Total Donations
        $topCampaigns = $this->statisticsRepo->getTopCampaigns();


        // 4. Donation Trends (daily totals)
        $donationTrends = $this->statisticsRepo->getDonationTrendsByTime();


        return [
            'most_payment' => $mostPayment,
            'total_payment' => round($totalPayment, 2),
            'top_campaigns' => $topCampaigns,
            'donation_trends' => [
                    'hourly' => $donationTrends['hourly'],
                    'daily' => $donationTrends['daily'],
                    'weekly' => $donationTrends['weekly'],
                ],        ];
    }

    public function getPointSystemStatistics(): array
    {
        // 1. Average points
        $avgPoints = $this->statisticsRepo->getAveragePoints();


        // 2. Score distribution
        $scoreDistribution = $this->statisticsRepo->getScoreDistribution();

        // 3. Highest priority complaint
        $mostHighComplaint = $this->statisticsRepo->getMostHighComplaint();


        return [
            'average_points' => round($avgPoints, 2),
            'score_distribution' => $scoreDistribution,
            'most_high_complaint' => $mostHighComplaint,
        ];
    }

}
