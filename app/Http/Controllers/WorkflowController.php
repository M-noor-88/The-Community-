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
        $workflow->transition($complaint, $request->status, $request->notes);

        return response()->json(['message' => 'تم تغيير حالة الشكوى بنجاح']);
    }


    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        if ($user->hasRole('client')) {
            $complaints = Complaint::where('user_id', $user->id)->get();
        } elseif ($user->hasRole('field_agent')) {
            $complaints = Complaint::where('assigned_to', $user->id)->get();
        } else {
            $complaints = Complaint::all(); // admin or manager
        }

        return response()->json($complaints);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $complaint = Complaint::with(['workflowLogs.user'])->findOrFail($id);

        return response()->json([
            'complaint' => $complaint,
            'workflow_logs' => $complaint->workflowLogs()->with('user')->latest()->get(),
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

       $categoryName = $complaint->category->name;

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


}
