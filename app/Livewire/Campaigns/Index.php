<?php

namespace App\Livewire\Campaigns;

use App\Models\Category;
use App\Services\ProjectService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $status = 'نشطة';                 // default tab
    protected $paginationTheme = 'tailwind';

    public ?int $category_id = null;  // null means show all categories


    protected ProjectService $service;

    // Inject the service early; boot() runs before render()
    public function boot(ProjectService $service): void
    {
        $this->service = $service;
    }

    // reset paginator when filter changes
    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryId(): void
    {
        $this->resetPage();
    }

    public function render()
    {

        $categories = Category::all();

        $projects = $this->service->getAllProjectsByTypeAndStatus('حملة رسمية', $this->status, $this->category_id);

        return view('livewire.campaigns.index', compact('projects', 'categories'))
            ->layout('layouts.app');
    }
}
