<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\VoteService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    use JsonResponseTrait;

    public function __construct(
        protected VoteService $voteService
    ) {}

    public function vote(Request $request, $projectId): JsonResponse
    {
        $request->validate([
            'value' => 'required|in:1,-1',
        ]);

        try {
            $this->voteService->voteOnProject($projectId, $request->value);

            return $this->success([], 'تم تسجيل صوتك!');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
