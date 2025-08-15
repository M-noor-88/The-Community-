<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use App\Services\Workflow\ComplaintWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Services\ComplaintsService;
use App\Http\Requests\UpdateComplaintRequest;

class WorkflowController extends Controller
{
    /**
     * @throws ValidationException
     */

     protected ComplaintsService $complaintsService;


    public function __construct(ComplaintsService $complaintsService)
    {
        $this->complaintsService = $complaintsService;
    }


    public function changeStatus(UpdateComplaintRequest $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $workflow = new ComplaintWorkflowService();

        // تنفيذ الانتقال
        $workflow->transition($complaint, $request->status, $request->notes);

        // إذا كانت الحالة الجديدة "تم التعيين" → نفذ تعيين الموظف تلقائيًا
        if ($request->status === 'تم التعيين') {
            $workflow->assignToRandomAgent($complaint);
        }

        $this->complaintsService->updateComplaintStatus($id, $request->all());

        return response()->json(['message' => 'تم تغيير حالة الشكوى بنجاح']);
    }


    public function show($id): \Illuminate\Http\JsonResponse
    {
        $complaint = Complaint::with(['category', 'user', 'assignedAgent', 'workflowLogs.user', 'statusDurations'])
            ->findOrFail($id);

        $all_complaints = $this->complaintsService->getComplaintsByID($id);

        $logs = $complaint->workflowLogs->map(function ($log) {
            return [
                'id' => $log->id,
                'from_status' => $log->from_status,
                'to_status' => $log->to_status,
                'role' => $log->role,
                'notes' => $log->notes,
                'date' => \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i'),
                'user' => [
                    'id' => $log->user->id ?? null,
                    'name' => $log->user->name ?? 'غير معروف',
                    'email' => $log->user->email ?? null,
                ]
            ];
        });

        $durations = $complaint->statusDurations->map(function ($duration) {
            $entered = \Carbon\Carbon::parse($duration->entered_at);
            $left = $duration->left_at ? \Carbon\Carbon::parse($duration->left_at) : now();

            return [
                'status' => $duration->status,
                'entered_at' => $entered->format('Y-m-d H:i'),
                'left_at' => $duration->left_at ? $left->format('Y-m-d H:i') : '',
                'duration_readable' => $entered->diffForHumans($left, true),
            ];
        });

        return response()->json([
            'complaint' => $all_complaints,
            'workflow_logs' => $logs,
            'status_durations' => $durations,
        ]);
    }




    public function logs($id)
    {
        $complaint = Complaint::with(['workflowLogs', 'workflowLogs.user'])->findOrFail($id);

        $response = [
            'complaint' => [
                'id' => $complaint->id,
                'title' => $complaint->title,
                'status' => $complaint->status,
                'created_at' => $this->formatDate($complaint->created_at)
            ],
            'logs' => $complaint->workflowLogs->map(function($log) {
                return [
                    'action' => $this->getActionDescription($log->from_status, $log->to_status),
                    'status_change' => "{$log->from_status} → {$log->to_status}",
                    'changed_by' => [
                        'id' => $log->changed_by,
                        'role' => $this->translateRole($log->role)
                    ],
                    'notes' => $log->notes,
                    'date' => $this->formatDate($log->created_at, true)
                ];
            })
        ];

        return response()->json($response);
    }

    protected function formatDate($date, $full = false)
    {
        if (!$date) return null;

        $carbonDate = \Carbon\Carbon::parse($date);

        $formats = [
            'gregorian' => $carbonDate->translatedFormat('j F Y'),
            'time' => $carbonDate->translatedFormat('h:i a'),
            'day' => $carbonDate->translatedFormat('l'),
        ];

        if ($full) {
            $formats['full'] = "{$formats['day']}، {$formats['gregorian']} - {$formats['time']} ";
            return $formats;
        }

        return "{$formats['day']}، {$formats['gregorian']} - {$formats['time']}";
    }

    protected function translateRole($role)
    {
        $roles = [
            'government_admin' => 'مسؤول حكومي',
            'field_agent' => 'مندوب ميداني',
            'complaint_manager' => 'مدير الشكاوى'
        ];

        return $roles[$role] ?? $role;
    }

    protected function getActionDescription($fromStatus, $toStatus)
    {
        $actions = [
            'انتظار' => ['تم التحقق' => 'تم التحقق الأولي'],
            'تم التحقق' => ['تم التعيين' => 'تم تعيين موظف ميداني'],
            'تم التعيين' => ['يتم التنفيذ' => 'بدأ التنفيذ الميداني'],
            'يتم التنفيذ' => ['منجزة' => 'تم إكمال العمل'],
            'منجزة' => ['مغلقة' => 'تم إغلاق الشكوى']
        ];

        return $actions[$fromStatus][$toStatus] ?? "تم تغيير الحالة من {$fromStatus} إلى {$toStatus}";
    }

   public function assignToFieldAgent($complaintId): \Illuminate\Http\JsonResponse
   {
       $complaint = Complaint::with('category')->findOrFail($complaintId);

       // استخرج القسم المرتبط بالشكوى
       $categoryName = $complaint->category->name;

       // جلب موظف ميداني بشكل عشوائي بدون ربط بالجداول الأخرى
       $agent = \App\Models\User::role('field_agent')
           ->inRandomOrder()
           ->first();

       if (!$agent) {
           return response()->json(['message' => 'لا يوجد موظف ميداني متاح حالياً'], 404);
       }

       $complaint->update(['assigned_to' => $agent->id]);

       return response()->json([
           'message' => 'تم تعيين الشكوى للموظف الميداني بنجاح',
           'assigned_to' => $agent->name,
           'agent_id' => $agent->id,
           'category' => $categoryName
       ]);
   }


    public function stats(): \Illuminate\Http\JsonResponse
    {
        $stats = (new ComplaintWorkflowService())->getComplaintsCountByStatus();
        return response()->json($stats);
    }


    public function autoAssign($id): \Illuminate\Http\JsonResponse
    {
        $complaint = Complaint::findOrFail($id);
        $agent = (new ComplaintWorkflowService())->assignToRandomAgent($complaint);

        return response()->json([
            'message' => 'تم تعيين موظف ميداني تلقائيًا.',
            'agent' => $agent,
        ]);
    }


    public function canTransition(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $targetStatus = $request->input('to');

        $workflow = new ComplaintWorkflowService();
        $can = $workflow->canTransition($complaint, $targetStatus) &&
            $workflow->canRoleTransition(Auth::user()->getRoleNames()[0], $complaint->status, $targetStatus);

        return response()->json(['can_transition' => $can]);
    }


    public function availableTransitions($id): \Illuminate\Http\JsonResponse
    {
        $complaint = Complaint::findOrFail($id);
        $workflow = new ComplaintWorkflowService();
        $currentStatus = $complaint->status;
        $role = Auth::user()->getRoleNames()[0];

        $nextStatuses = $workflow->transitions[$currentStatus] ?? [];

        // فلترة الحالات بناءً على صلاحيات الدور
        $allowed = array_filter($nextStatuses, function ($toStatus) use ($workflow, $role, $currentStatus) {
            return $workflow->canRoleTransition($role, $currentStatus, $toStatus);
        });

        return response()->json([
            'current_status' => $currentStatus,
            'allowed_transitions' => array_values($allowed)
        ]);
    }

}
