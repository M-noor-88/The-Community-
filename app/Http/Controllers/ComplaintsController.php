<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Services\ComplaintsService;
use App\Http\Requests\ComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use Illuminate\Support\Facades\Log;

use Exception;

class ComplaintsController extends Controller
{
    use JsonResponseTrait;
    protected ComplaintsService $complaintsService;
    public function __construct(ComplaintsService $complaintsService)
    {
        $this->complaintsService = $complaintsService;
    }

    public function index(): JsonResponse
    {
        try {
            $complaints = $this->complaintsService->getAllComplaints();
            return $this->success($complaints, 'Complaints retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function complaintsByCategory($category_id): JsonResponse
    {
        try {
            $complaints = $this->complaintsService->getComplaintsByCategory($category_id);
            return $this->success($complaints, 'Complaints retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function complaintsByStatus($status = null): JsonResponse
    {
        try {
            if (is_null($status) || $status === 'null') {
                $status = 'انتظار';
            }
            $complaints = $this->complaintsService->getComplaintsByStatus($status);
            return $this->success($complaints, 'Complaints retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function nearbyComplaints(Request $request): JsonResponse
    {
        try {
            $complaints = $this->complaintsService->getNearbyComplaints($request->all());
            return $this->success($complaints, 'Complaints retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function complaintsByCatAndSt(Request $request): JsonResponse
    {
        try {
            $complaints = $this->complaintsService->getComplaintsByCatAndSt($request->all());
            return $this->success($complaints, 'Complaints retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function store(ComplaintRequest $request): JsonResponse
    {
        try {
            $complaint = $this->complaintsService->createComplaint($request->all());
            return $this->success($complaint, 'Complaint created successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function updateStatus(UpdateComplaintRequest $request, $id): JsonResponse
    {
        try {
            Log::info($request);
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

    public function complaintCategories(): JsonResponse
    {
        try {
            $complaints = $this->complaintsService->getComplaintCategories();
            return $this->success($complaints, 'Complaints retrieved successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function createCategory(Request $request): JsonResponse
    {
        try {
            $complaints = $this->complaintsService->createComplaintCategory($request['name']);
            return $this->success($complaints, 'category created  successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function updateCategory(Request $request, $id): JsonResponse
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

    public function  getFormalBook($id)
    {
        $pdf = $this->complaintsService->downloadFormalBook($id);
        return $pdf->stream('complaint_' . $id . '.pdf');
    }

    public function downloadFormalBook($id)
    {
        $pdf = $this->complaintsService->downloadFormalBook($id);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'complaint_' . $id . '.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
