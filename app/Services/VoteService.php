<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\RecommendationRepository;
use App\Repositories\VoteRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class VoteService
{
    protected VoteRepository $voteRepository;

    protected RecommendationRepository $recommendRepo;

    public function __construct(VoteRepository $voteRepository, RecommendationRepository $recommendRepo)
    {
        $this->voteRepository = $voteRepository;
        $this->recommendRepo = $recommendRepo;
    }

    /**
     * @throws Exception
     */
    public function voteOnProject($projectId, $value): void
    {
        $project = Project::find($projectId);
        $userId = Auth::id();
        if (! $project) {
            throw new Exception('المشروع غير موجود');
        }

        if ($project->type !== 'مبادرة') {
            throw new Exception('التصويت متاح فقط في المبادرات');
        }

        $this->recommendRepo->updateInterests($project->category->id, $userId, 2);

        $this->voteRepository->storeVote($userId, $projectId, $value);
    }
}
