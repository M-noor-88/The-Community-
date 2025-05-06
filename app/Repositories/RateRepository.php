<?php

namespace App\Repositories;

use App\Models\Rating;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class RateRepository
{
    /**
     * @throws Exception
     */
    public function create($data, $user_id)
    {
        $exists = Rating::where('user_id', $user_id)
            ->where('project_id', $data['project_id'])
            ->exists();

        if ($exists) {
            throw new Exception('لقد قمت بتقييم هذا المشروع مسبقًا.');
        }

        return Rating::create([
            'user_id' => $user_id,
            'project_id' => $data['project_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);
    }

    public function getProjectAverageRating($projectId): float
    {
        return Rating::where('project_id', $projectId)->avg('rating') ?? 0;
    }

    public function getProjectRatings($projectId): Collection
    {
        return Rating::with('user')
            ->where('project_id', $projectId)
            ->latest()
            ->get();
    }
}
