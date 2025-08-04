<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use App\Services\Workflow\ComplaintWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WorkflowController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $complaint = Complaint::findOrFail($id);
        $workflow = new ComplaintWorkflowService();

        // تنفيذ الانتقال
        $workflow->transition($complaint, $request->status, $request->notes);

        // إذا كانت الحالة الجديدة "تم التعيين" → نفذ تعيين الموظف تلقائيًا
        if ($request->status === 'تم التعيين') {
            $workflow->assignToRandomAgent($complaint);
        }

        return response()->json(['message' => 'تم تغيير حالة الشكوى بنجاح']);
    }


    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $complaints = Complaint::with('category')
            ->latest()
            ->take(50)
            ->get();

        $response = $complaints->map(function ($complaint) {
            return [
                'id' => $complaint->id,
                'title' => $complaint->title,
                'region' => $complaint->region,
                'status' => $complaint->status,
                'category' => $complaint->category?->name,
                'priority'=> $complaint->priority_points,
                'created_at' => $complaint->created_at->format('Y-m-d H:i'),
            ];
        });

        return response()->json($response);
    }




    public function show($id): \Illuminate\Http\JsonResponse
    {
        $complaint = Complaint::with(['category', 'user', 'assignedAgent', 'workflowLogs.user', 'statusDurations'])
            ->findOrFail($id);

        $mappedComplaint = [
            'id' => $complaint->id,
            'title' => $complaint->title,
            'description' => $complaint->description,
            'region' => $complaint->region,
            'status' => $complaint->status,
            'priority_points' => $complaint->priority_points,
            'created_at' => $complaint->created_at->format('Y-m-d H:i'),
            'last_status_changed_at' => optional($complaint->last_status_changed_at)->format('Y-m-d H:i'),
            'category' => $complaint->category?->name,
            'user' => [
                'id' => $complaint->user->id,
                'name' => $complaint->user->name,
            ],
            'assigned_agent' => $complaint->assignedAgent ? [
                'id' => $complaint->assignedAgent->id,
                'name' => $complaint->assignedAgent->name,
            ] : null,
        ];

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
            'complaint' => $mappedComplaint,
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

    public function checkEscalation($id): \Illuminate\Http\JsonResponse
    {
        $complaint = Complaint::findOrFail($id);
        (new ComplaintWorkflowService())->checkAndEscalate($complaint);

        return response()->json(['message' => 'تم التحقق من التصعيد التلقائي لهذه الشكوى.']);
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

    public function escalated(): \Illuminate\Http\JsonResponse
    {
        $complaints = Complaint::where('status', 'تم التصعيد')->latest()->get();
        return response()->json($complaints);
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
