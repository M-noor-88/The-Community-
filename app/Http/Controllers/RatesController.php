<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Services\RatesService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RatesController extends Controller
{
    use JsonResponseTrait;

    public function __construct(
        protected RatesService $ratesService,
    ) {}

    public function addRateToProject(RateRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $userId = Auth::id();

            $rate = $this->ratesService->addRateToProject($validated, $userId);

            return $this->success($rate, 'تم إضافة التقييم بنجاح');

        } catch (Exception $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function getProjectRatings($projectId): JsonResponse
    {
        try {
            $ratings = $this->ratesService->getProjectRatings($projectId);

            return $this->success('قائمة التقييمات', $ratings);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
