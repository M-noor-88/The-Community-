<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectRepository
{
    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function get($projectId): Project
    {
        return Project::with([
            'user',
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

    public function getAllProjectsByType($type): LengthAwarePaginator
    {
        return Project::with([
            'user',
            'image',
            'category',
            'location',
            'votes',
            'totalVotes',
            'donations',
            'donationSummary',
            'participants',
        ])
            ->where('type', $type)
            ->paginate(10);
    }

    public function getProjectsByCategoryAndType($categoryId, $type = null): LengthAwarePaginator
    {
        $query = Project::with([
            'user',
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

        return $query->paginate(10);
    }

    public function getNearbyProjects($latitude, $longitude, $distanceKm = 10, $type = null, $categoryId = null): LengthAwarePaginator
    {
        $distanceFormula = "(6371 * acos(cos(radians($latitude)) * cos(radians(locations.latitude)) * cos(radians(locations.longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(locations.latitude))))";

        $query = Project::with([
            'user',
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

        return $query->paginate(10);
    }
}
