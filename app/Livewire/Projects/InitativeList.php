<?php

namespace App\Livewire\Projects;

use App\Models\Category;
use App\Models\Project;
use Livewire\Component;

class InitativeList extends Component
{

    public array $initiatives = [];
    public array $statuses = [ 'تصويت', 'ملغية'];
    public $statusFilter = '';
    public $categoryFilter = '';
    public $sortByTopVotes = false;
    public $categories = [];

    public function mount(): void
    {
        $this->categories = Category::select('id', 'name')->get()->toArray();
        $this->loadInitiatives();
    }

    public function updated($propertyName): void
    {
        $this->loadInitiatives();

//        if (in_array($propertyName, ['statusFilter', 'categoryFilter', 'sortByTopVotes'])) {
//            $this->loadInitiatives();
//        }
    }

    public function loadInitiatives(): void
    {
        $query = Project::query()
            ->where('type', 'مبادرة')
            ->with([
                'user.clientProfile.image',
                'image',
                'category',
                'location',
                'votes',
                'totalVotes',
            ]);

        // Apply filters
        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->categoryFilter !== '') {
            $query->where('category_id', $this->categoryFilter);
        }

        // Apply vote sorting (safely with leftJoin)
        if ($this->sortByTopVotes) {
            $query->leftJoin('vote_project_totals', 'projects.id', '=', 'vote_project_totals.project_id')
                ->orderByDesc('vote_project_totals.likes')
                ->select('projects.*'); // Needed after join
        } else {
            $query->orderByDesc('projects.created_at');
        }

        $this->initiatives = $query->get()->map(function ($project) {
            return [
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'status' => $project->status,
                'user' => [
                    'userID' => $project->user?->id,
                    'created_by' => $project->user?->name,
                    'role' => $project->user?->getRoleNames()[0] ?? 'unknown',
                    'userImage' => $project->user->clientProfile->image->image_url ?? 'null',
                ],
                'image_url' => $project->image?->image_url,
                'category' => $project->category?->name,
                'location' => [
                    'name' => $project->location?->name,
                    'latitude' => $project->location?->latitude,
                    'longitude' => $project->location?->longitude,
                ],
                'votes_count' => $project->votes?->count() ?? 0,
                'likes' => $project->totalVotes?->likes ?? 0,
                'dislikes' => $project->totalVotes?->dislikes ?? 0,
                'created_at' => $project->created_at?->format('d/m/Y'),
                'type' => $project->type,
            ];
        })->toArray();
    }


    public function render()
    {
        return view('livewire.projects.initative-list')->layout('layouts.app');
    }
}
