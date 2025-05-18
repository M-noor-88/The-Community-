<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintCategoryRequest;
use App\Http\Requests\ComplaintRequest;
use App\Http\Requests\FilterComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use App\Services\ComplaintsService;
use App\Services\PdfGeneratorService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ComplaintsController extends Controller
{
    use JsonResponseTrait;

    protected ComplaintsService $complaintsService;

    protected PdfGeneratorService $pdfGeneratorService;

    public function __construct(ComplaintsService $complaintsService, PdfGeneratorService $pdfGeneratorService)
    {
        $this->pdfGeneratorService = $pdfGeneratorService;
        $this->complaintsService = $complaintsService;
    }

    public function filterComplaintsClient(FilterComplaintRequest $request): JsonResponse
    {
        try {
            $filters = $request->only(['status', 'category_id', 'nearby', 'location_id']);
            $complaints = $this->complaintsService->filterComplaintsClient($filters);
            if ($complaints['complaints']->isEmpty()) {
                return $this->success('No complaints found', 204);
            }

            return $this->success($complaints, 'Complaints retrieved successfully');
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function filterComplaintsAdmin(FilterComplaintRequest $request): JsonResponse
    {
        try {
            $filters = $request->only(['status', 'category_id', 'location_id']);
            $complaints = $this->complaintsService->filterComplaintsAdmin($filters);
            if ($complaints['complaints']->isEmpty()) {
                return $this->success('No complaints found', 204);
            }

            return $this->success($complaints, 'Complaints retrieved successfully');
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(ComplaintRequest $request): JsonResponse
    {
        try {
            $complaint = $this->complaintsService->createComplaint($request->all());

            return $this->success($complaint, 'Complaint created successfully', 201);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getAllCategories(): JsonResponse
    {
        try {
            $categories = $this->complaintsService->getComplaintCategories();

            return $this->success($categories, 'Categories retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function updateStatus(UpdateComplaintRequest $request, $id): JsonResponse
    {
        try {
            $complaint = $this->complaintsService->updateComplaintStatus($id, $request->all());

            return $this->success($complaint, 'Complaint status updated successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function complaintsByID($id): JsonResponse
    {
        try {
            $complaints = $this->complaintsService->getComplaintsByID($id);

            return $this->success($complaints, 'Complaints retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function createCategory(ComplaintCategoryRequest $request): JsonResponse
    {
        try {
            $complaints = $this->complaintsService->createComplaintCategory($request['name']);

            return $this->success($complaints, 'category created  successfully', 201);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function updateCategory(ComplaintCategoryRequest $request, $id): JsonResponse
    {
        try {
            $complaints = $this->complaintsService->updateComplaintCategory($id, $request['name']);

            return $this->success($complaints, 'category updated successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function deleteCategory($id): JsonResponse
    {
        try {
            $complaints = $this->complaintsService->deleteComplaintCategory($id);

            return $this->success($complaints, 'category deleted successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getFormalBook($id): StreamedResponse
    {
        $pdf = $this->pdfGeneratorService->downloadFormalBook($id);

        return $pdf->stream('complaint_'.$id.'.pdf');
    }

    public function downloadFormalBook($id): StreamedResponse
    {
        $pdf = $this->pdfGeneratorService->downloadFormalBook($id);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'complaint_'.$id.'.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
