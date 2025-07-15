<?php

namespace App\Livewire\Campaigns;

use App\Services\ProjectService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $status = 'نشطة';                 // default tab
    protected $paginationTheme = 'tailwind';

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

    public function render()
    {
        // ONLY local variable – never dehydrated
        $projects = $this->service
            ->getAllProjects('حملة رسمية', $this->status);

        return view('livewire.campaigns.index', compact('projects'))
            ->layout('layouts.app');
    }
}
