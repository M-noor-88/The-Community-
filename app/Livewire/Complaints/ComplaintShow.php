<?php

namespace App\Livewire\Complaints;

use App\Models\Complaint;
use App\Models\ComplaintStatusDuration;
use App\Repositories\ImageRepository;
use App\Services\Workflow\ComplaintWorkflowService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class ComplaintShow extends Component
{
    use WithFileUploads;

    public Complaint $complaint;
    public $logs;
    public $durations;
    public array $availableTransitions = [];
    public string $notes = '';

    protected ComplaintWorkflowService $workflow;

    protected  ImageRepository $imageRepo;


    public $achievementImages = [];



    public function uploadAchievementImages(): void
    {
        if (!auth()->user()->hasRole('field_agent')) {
            $this->addError('achievementImages', 'غير مسموح لك برفع صور الإنجاز.');
            return;
        }

        $this->validate([
            'achievementImages.*' => 'image|max:5120',
        ]);

        foreach ($this->achievementImages as $file) {
            $image = DB::transaction(fn () => $this->imageRepo->createPlaceholder());

            $this->imageRepo->storeTempImageAndDispatch($file, $image->id);

            $this->complaint->achievementImages()->attach($image->id , ['type' => 'achievement']);
        }

//        $this->achievementImages = [];
        $this->complaint->refresh();

        session()->flash('message', 'تم رفع صور الإنجاز بنجاح.');
    }


    public function boot(ComplaintWorkflowService $workflow , ImageRepository $imageRepository)
    {
        $this->workflow = $workflow;
        $this->imageRepo = $imageRepository;

    }

    public function mount($id)
    {
        $this->complaint = Complaint::with([
            'user',
            'category',
            'location',
            'assignedAgent',
            'complaintImages',
            'achievementImages',
            'workflowLogs.user',
        ])->findOrFail($id);

        $this->logs = $this->complaint->workflowLogs()->with('user')->latest()->get();
        $this->durations = ComplaintStatusDuration::where('complaint_id', $id)->get();

        $this->loadTransitions();
    }

    public function assignToFieldAgent(): void
    {
        try {

            $assigned = $this->workflow->assignToRandomAgent($this->complaint);
            $this->complaint->refresh();

            $this->applyTransition('تم التعيين');
            session()->flash('message', "تم تعيين الشكوى إلى الموظف: {$assigned['agent_name']}");
        } catch (ValidationException $e) {
            $this->addError('assign', $e->getMessage());
        }
    }



    public function loadTransitions(): void
    {
        $role = Auth::user()->getRoleNames()->first();
        $current = $this->complaint->status;
        $all = $this->workflow->transitions[$current] ?? [];

        $this->availableTransitions = array_filter($all, function ($to) use ($role, $current) {
            return $this->workflow->canRoleTransition($role, $current, $to);
        });
    }

    public function applyTransition(string $to): void
    {
        try {
            $this->workflow->transition($this->complaint, $to, $this->notes);
            $this->complaint->refresh();
            $this->logs = $this->complaint->workflowLogs()->with('user')->latest()->get();
            $this->durations = ComplaintStatusDuration::where('complaint_id', $this->complaint->id)->get();
            $this->notes = '';
            $this->loadTransitions();
            session()->flash('message', "تم تغيير الحالة بنجاح إلى {$to}");
        } catch (ValidationException $e) {
            $this->addError('transition', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.complaints.complaint-show', [
            'location' => $this->complaint->location,
            'lat' => $this->complaint->location?->latitude ?? 33.5138,
            'lng' => $this->complaint->location?->longitude ?? 36.2765,
            'createdAt' => $this->complaint->created_at?->translatedFormat('d F Y, h:i A') ?? '-',
            'updatedAt' => $this->complaint->updated_at?->translatedFormat('d F Y, h:i A') ?? '-',
            'lastStatusChangedAt' => $this->complaint->last_status_changed_at
                ? \Carbon\Carbon::parse($this->complaint->last_status_changed_at)->translatedFormat('d F Y, h:i A')
                : '-',
        ])->layout('layouts.app');
    }


}
