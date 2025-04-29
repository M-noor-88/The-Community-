<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Vote;
use App\Models\VoteProjectTotal;
use Exception;

class VoteRepository
{
    // Store a vote for a project
    /**
     * @throws \Exception
     */
    public function storeVote($userId, $projectId, $value): void
    {
        $existingVote = Vote::where('user_id', $userId)->where('project_id', $projectId)->first();

        if ($existingVote) {
            throw new Exception('لقد قمت بالتصويت بالفعل');
        }

        $vote = Vote::create([
            'user_id' => $userId,
            'project_id' => $projectId,
            'value' => $value,
        ]);

        // Update total votes for the project (like/dislike count)
        $this->updateVoteTotals($projectId);

    }

    private function updateVoteTotals($projectId): void
    {
        $project = Project::find($projectId);

        $likes = Vote::where('project_id', $projectId)->where('value', 1)->count();
        $dislikes = Vote::where('project_id', $projectId)->where('value', -1)->count();

        VoteProjectTotal::updateOrCreate(
            ['project_id' => $projectId],
            ['likes' => $likes, 'dislikes' => $dislikes]
        );
    }
}
