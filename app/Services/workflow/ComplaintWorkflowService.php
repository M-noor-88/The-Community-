<?php


namespace App\Services\Workflow;

use App\Models\Complaint;
use App\Models\ComplaintWorkflowLog;
use App\Models\ComplaintStatusDuration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ComplaintWorkflowService
{
    protected array $transitions = [
        'انتظار' => ['تم التحقق', 'مرفوضة'],
        'تم التحقق' => ['تم التعيين', 'مرفوضة', 'تم التصعيد'],
        'تم التعيين' => ['يتم التنفيذ'],
        'يتم التنفيذ' => ['منجزة'],
        'منجزة' => ['مغلقة'],
        'تم التصعيد' => ['تم التحقق'],
    ];

    protected array $rolePermissions = [
        'government_admin' => ['انتظار', 'تم التحقق', 'تم التعيين', 'مرفوضة', 'مغلقة' ,  'منجزة'],
        'complaint_manager' => ['تم التحقق', 'تم التعيين', 'يتم التنفيذ'],
        'field_agent' => ['يتم التنفيذ', 'تم التعيين' ,  'منجزة'],
    ];

    protected array $statusEscalationTimes = [
        'تم التحقق' => 48,
        'تم التعيين' => 72,
        'يتم التنفيذ' => 168,
    ];

    public function canTransition(Complaint $complaint, string $to): bool
    {
        $from = $complaint->status;
        return isset($this->transitions[$from]) && in_array($to, $this->transitions[$from]);
    }

    public function hasPermission(string $role, string $fromStatus): bool
    {
        return in_array($fromStatus, $this->rolePermissions[$role] ?? []);
    }

    public function transition(Complaint $complaint, string $to, ?string $notes = null): void
    {
        $from = $complaint->status;
        $user = Auth::user();
        $role =  $user->getRoleNames()[0];

        if (!$this->canTransition($complaint, $to)) {
            throw ValidationException::withMessages(['status' => 'الانتقال غير مسموح من ' . $from . ' إلى ' . $to]);
        }

        if (!$this->hasPermission($role, $from)) {
            throw ValidationException::withMessages(['role' => 'ليس لديك صلاحية تغيير الحالة الحالية']);
        }

        $this->closePreviousStatusDuration($complaint, $from);

        ComplaintStatusDuration::create([
            'complaint_id' => $complaint->id,
            'status' => $to,
            'entered_at' => now(),
        ]);

        $complaint->update([
            'status' => $to,
            'last_status_changed_at' => now(),
        ]);

        ComplaintWorkflowLog::create([
            'complaint_id' => $complaint->id,
            'from_status' => $from,
            'to_status' => $to,
            'changed_by' => $user->id,
            'role' => $role,
            'notes' => $notes,
        ]);

        Log::info("Complaint {$complaint->id} transitioned from {$from} to {$to} by user {$user->id} with role {$role}");
    }

    protected function closePreviousStatusDuration(Complaint $complaint, string $status): void
    {
        $record = ComplaintStatusDuration::where('complaint_id', $complaint->id)
            ->where('status', $status)
            ->whereNull('left_at')
            ->latest('entered_at')
            ->first();

        if ($record) {
            $record->update(['left_at' => now()]);
        }
    }

    public function checkAndEscalate(Complaint $complaint): void
    {
        $currentStatus = $complaint->status;

        if (!isset($this->statusEscalationTimes[$currentStatus])) {
            return;
        }

        $durationAllowed = $this->statusEscalationTimes[$currentStatus];
        $lastChanged = $complaint->last_status_changed_at;

        if (!$lastChanged) {
            return;
        }

        $hoursPassed = now()->diffInHours($lastChanged);

        if ($hoursPassed >= $durationAllowed && $this->canTransition($complaint, 'تم التصعيد')) {
            $this->transition($complaint, 'تم التصعيد', "تم التصعيد تلقائيًا بعد تجاوز المدة المسموح بها في حالة {$currentStatus}");
        }
    }

    public function getComplaintsCountByStatus(): array
    {
        return Complaint::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }
}
