<?php

namespace App\Http\Controllers;

use App\Services\ProjectPromotionService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GovernmentProjectController extends Controller
{
    use JsonResponseTrait;

    public function __construct(protected ProjectPromotionService $service) {}

    //  List initiatives
    public function index(): JsonResponse
    {
        try {
            $projects = $this->service->listInitiativesSorted();

            return $this->success($projects);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

    }

    //  Promote to حملة رسمية
    public function promote(Request $request, $projectId): JsonResponse
    {
        $request->validate([
            'execution_date' => 'nullable|date',
            'status' => 'nullable|in:نشطة,ملغية,منجزة',
        ]);

        try {
            $project = $this->service->assignAsCampaign($projectId, $request->execution_date, $request->status);

            return $this->success($project, 'تم تحويل تحديث حالة المشروع');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }

    // Assign as completed BY Volunteer Admin
    public function assignAsCompleted(Request $request, $projectId): JsonResponse
    {
        $request->validate([
            'execution_date' => 'nullable|date',
            'status' => 'nullable|in:نشطة,ملغية,منجزة',
        ]);

        try {
            $project = $this->service->assignAsCompleted($projectId, $request->execution_date, $request->status);

            return $this->success($project, 'تم تحويل تحديث حالة المشروع');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }
}
