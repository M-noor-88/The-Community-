<?php

namespace App\Livewire\Campaigns;

use App\Repositories\CampaignParticipantRepository;
use App\Repositories\RateRepository;
use App\Services\DonationService;
use App\Services\ProjectService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public int $projectId;

    // Injected once in boot()
    protected ProjectService $projectService;
    protected RateRepository $rateRepo;

    /* ------------ Lifecycle ------------ */

    public function boot(ProjectService $projectService, RateRepository $rateRepo): void
    {
        $this->projectService = $projectService;
        $this->rateRepo       = $rateRepo;
    }

    public function mount(int $project): void
    {
        // keep only the id as dehydrated state
        $this->projectId = $project;
    }

    /* ------------ Render ------------ */

    public function render()
    {
        /* —— Project details (already transformed by your service) —— */
        $project = $this->projectService->show($this->projectId);

        /* —— Ratings —— */
        $rawRatings = $this->rateRepo->getProjectRatings($this->projectId);

        // convert Eloquent models ➜ plain arrays so Livewire can serialise them
        $ratings = $rawRatings->map(fn ($r) => [
            'user_name'   => $r->user->name,
            'avatar'      => $r->user->clientProfile->image->image_url ?? '/placeholder.png',
            'rating'      => (int) $r->rating,
            'comment'     => $r->comment,
            'created_ago' => $r->created_at->diffForHumans(),
        ])->all();

        $avgRating = round($rawRatings->avg('rating') ?? 0, 1);

        return view('livewire.campaigns.show', [
            'project'   => $project,
            'ratings'   => $ratings,
            'avgRating' => $avgRating,
        ])->layout('layouts.app');
    }
}
