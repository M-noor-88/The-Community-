<?php

namespace App\Livewire\Complaints;

use App\Models\Complaint;
use App\Models\ComplaintCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ComplaintsTable extends Component
{
    use WithPagination;

    public $status = null;
    public $categoryId = null;
    public $region = null;

    public function updating($field)
    {
        $this->resetPage(); // reset pagination on filter change
    }

    public function resetFilters()
    {
        $this->reset(['status', 'categoryId', 'region']);
        $this->resetPage();
    }

    public function render()
    {
        $complaints = Complaint::with(['user' , 'complaintImages', 'category', 'assignedAgent'])
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->categoryId, fn($q) => $q->where('complaint_category_id', $this->categoryId))
            ->when($this->region, fn($q) => $q->where('region', $this->region))
            ->latest()
            ->paginate(10);

        $categories = ComplaintCategory::select('id', 'name')->get();
        $statuses = ['انتظار', 'تم التحقق', 'تم التعيين', 'يتم التنفيذ', 'منجزة', 'مغلقة', 'مرفوضة', 'تم التصعيد'];
//        dd($complaints[0]->complaintImages()->first()->image_url);
        return view('livewire.complaints.complaints-table', compact('complaints', 'categories', 'statuses'))->layout('layouts.app');
    }
}


//'انتظار', 'تم التحقق', 'تم التعيين', 'يتم التنفيذ', 'منجزة', 'مغلقة', 'مرفوضة', 'تم التصعيد'
