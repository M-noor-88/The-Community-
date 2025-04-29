<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\VoteRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class VoteService
{
    protected VoteRepository $voteRepository;

    public function __construct(VoteRepository $voteRepository)
    {
        $this->voteRepository = $voteRepository;
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

        $this->voteRepository->storeVote($userId, $projectId, $value);
    }
}
