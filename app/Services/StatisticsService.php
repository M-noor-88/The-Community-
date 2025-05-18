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
    public function getComplaintStatistics(): array
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
}
