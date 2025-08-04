<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\VoteProjectTotal;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProjectRepository
{
    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function getPromoted() : LengthAwarePaginator
    {
        return Project::where('is_promoted', true)
            ->where('type' , 'حملة رسمية')->where('status' , 'نشطة')
            ->orderByDesc('is_promoted')  // Promoted campaigns on top
            ->orderByDesc('created_at')   // Then recent ones
            ->with([
                'user.clientProfile',
                'image',
                'category',
                'location',
                'votes',
                'totalVotes',
                'donations',
                'donationSummary',
                'participants',
            ])
            ->paginate(50);

    }
    public function get($projectId): Project
    {
        return Project::with([
            'user.clientProfile',
            'image',
            'category',
            'location',
            'votes',
            'totalVotes',
            'donations',
            'donationSummary',
            'participants',
        ])->where('id', $projectId)->first();
    }

    public function getAllProjectsByType($type = null, $status = null): LengthAwarePaginator
    {
        $query = Project::with([
            'user.clientProfile',
            'image',
            'category',
            'location',
            'votes',
            'totalVotes',
            'donations',
            'donationSummary',
            'participants',
        ]);

        if ($status == 'منجزة') {
            $query->with('ratings.user');
        }

        $query->where('type', $type);

        if (! is_null($status)) {
            $query->where('status', $status);
        }

        return $query->paginate(50);
    }

    public function getProjectsByCategoryAndType($categoryId, $type = null): LengthAwarePaginator
    {
        $query = Project::with([
            'user.clientProfile',
            'image',
            'category',
            'location',
            'votes',
            'totalVotes',
            'donations',
            'donationSummary',
            'participants',
        ])->where('category_id', $categoryId);

        if ($type) {
            $query->where('type', $type);
        }

        return $query->paginate(50);
    }

    public function getNearbyProjects($latitude, $longitude, $distanceKm = 10, $type = null, $categoryId = null): LengthAwarePaginator
    {
        $distanceFormula = "(6371 * acos(cos(radians($latitude)) * cos(radians(locations.latitude)) * cos(radians(locations.longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(locations.latitude))))";

        $query = Project::with([
            'user.clientProfile',
            'image',
            'category',
            'location',
            'votes',
            'totalVotes',
            'donations',
            'donationSummary',
            'participants',
        ])
            ->join('locations', 'projects.location_id', '=', 'locations.id')
            ->select('projects.*')
            ->whereRaw("$distanceFormula < ?", [$distanceKm]);

        if ($type) {
            $query->where('projects.type', $type);
        }

        if ($categoryId) {
            $query->where('projects.category_id', $categoryId);
        }

        return $query->paginate(50);
    }

    //  Get initiatives sorted by votes desc
    public function getTopInitiatives(): Collection
    {
        return Project::with('totalVotes')
            ->where('type', 'مبادرة')
            ->orderByDesc(
                VoteProjectTotal::select('likes')
                    ->whereColumn('project_id', 'projects.id')
            )
            ->get();
    }

    //  Assign مبادرة to حملة رسمية
    public function promoteToOfficialCampaign(Project $project, array $data): Project
    {

        $project->update([
            'type' => 'حملة رسمية',
            'Execution_date' => $data['execution_date'] ?? null,
            'status' => $data['status'] ?? 'ملغية',
        ]);
        $project->save();

        return $project;
    }

    /**
     * @throws Exception
     */
    public function deleteIfInitiativeOwner($projectId, $userId)
    {
        $project = Project::where('id', $projectId)
            ->where('type', 'مبادرة')
            ->where('user_id', $userId)
            ->first();

        if (! $project) {
            throw new Exception('غير مصرح لك بحذف هذا المشروع أو أنه ليس مبادرة');
        }

        return $project->delete();
    }

    // Recommendation
    public function getRecommendations($userID, $status = null, $type = null): LengthAwarePaginator
    {
        $topCategories = DB::table('user_interests')
            ->where('user_id', $userID)
            ->orderByDesc('interest_score')
            ->pluck('category_id');

        $query = Project::with([
            'user.clientProfile',
            'image',
            'category',
            'location',
            'votes',
            'totalVotes',
            'donations',
            'donationSummary',
            'participants',
        ])->whereIn('category_id', $topCategories);

        if ($status != null) {
            $query->where('status', $status);
        }

        if ($type != null) {
            $query->where('type', $type);
        }

        return $query->paginate(50);

    }

    public function getRelatedProjects(Project $project, int $limit = 5)
    {
        return Project::where('category_id', $project->category_id)
            ->where('id', '!=', $project->id)
            ->where('is_archived', false)
            ->where('type' , 'حملة رسمية')
            ->whereIn('status' , ['نشطة' , 'منجزة'])
            ->latest()
            ->take($limit)
            ->get();
    }
}
