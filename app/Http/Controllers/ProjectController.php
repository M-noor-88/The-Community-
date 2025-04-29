<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectCreateRequest;
use App\Services\ProjectService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use JsonResponseTrait;

    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function store(ProjectCreateRequest $request): JsonResponse
    {
        try {
            $project = $this->projectService->create($request->validated());

            return $this->success($project, 'تم إنشاء المشروع بنجاح');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    // جميع المبادرات التي تحتاج الى تصويت ( من المستخدمين)
    public function getProjects(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required',
        ]);
        try {
            $projects = $this->projectService->getAllProjects($request->type);

            return $this->success($projects);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    // جميع المشاريع , المبادرات أو الحملات الرسمية حسب التصنيف
    public function getProjectsByCategory($category_id, Request $request): JsonResponse
    {
        try {

            $request->validate([
                'type' => 'required|in:مبادرة,حملة رسمية',
            ]);

            $projects = $this->projectService->getAllProjectsByCategoryAndType($category_id, $request->type);

            return $this->success($projects, 'جميع المشاريع حسب التصنيف');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    // جميع المشاريع , المبادرات أو الحملات الرسمية حسب التصنيف , والقريبة من موقع المستخدم Kilometer in
    public function getNearbyProjects(Request $request): JsonResponse
    {
        $request->validate([
            'distance' => 'nullable|numeric',
            'type' => 'nullable|string',
            'category_id' => 'nullable|integer',
        ]);

        try {
            $distanceKm = $request->input('distance', 10);
            $type = $request->input('type');
            $categoryId = $request->input('category_id');

            $projects = $this->projectService->getNearbyProjects($distanceKm, $type, $categoryId);

            return $this->success($projects);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }

    //    رؤية تفاصيل حملة رسمية
    public function show($projectId): JsonResponse
    {
        try {
            $project = $this->projectService->show($projectId);

            return $this->success($project, 'Showed');

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
