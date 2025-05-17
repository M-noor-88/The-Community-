<?php

namespace App\Services;


use App\Repositories\ComplaintsRepository;
use App\Repositories\LocationRepository;
use App\Repositories\ImageRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use App\Enums\ComplaintStatus;
use App\Models\ComplaintCategory;
use App\Http\Resources\ComplaintResource;
use  Exception;


class ComplaintsService
{
    public function __construct(
        private LocationRepository $locationRepo,
        private ImageRepository $imageRepo,
        private ComplaintsRepository $complaintsRepo,
    ) {}

    public function getResponseDetails($complaints): array
    {
        $data = [
            'total' => $complaints->count(),
            'complaints' => $complaints,
            'complaint_categories' => $this->getComplaintCategories(),
            'complaint_locations' => $this->locationRepo->getAllLocations(),
        ];
        return $data;
    }

    public function filterComplaintsClient(array $filters): array
    {
        $complaints = $this->complaintsRepo->applyCommonFilters($filters);

        if (isset($filters['nearby']) && $filters['nearby']) {
            $complaints = $this->complaintsRepo->applyNearbyFilter($complaints);
        }
        $complaints = $complaints->get();

        $FullConlaints = $complaints->map(function ($complaint) {
            return new ComplaintResource($complaint);
        });
        return $this->getResponseDetails($FullConlaints);
    }

    public function filterComplaintsAdmin(array $filters): array
    {
        $complaints = $this->complaintsRepo->applyCommonFilters($filters);
        $complaints = $complaints->get();
        $FullConlaints = $complaints->map(function ($complaint) {
            return new ComplaintResource($complaint);
        });
        return $this->getResponseDetails($FullConlaints);
    }

    public function createComplaint(array $request): array
    {
        $complaintImages = $request['complaintImages'] ?? [];
        $attachedImageIds = [];
        DB::beginTransaction();

        try {
            $location_id = $this->locationRepo->create([
                'latitude' => $request['latitude'],
                'longitude' => $request['longitude'],
                'area' => $request['area'] ?? 'غير معروف',
            ]);

            $user = Auth::user();
            if (!$user) {
                throw new Exception('User not authenticated.');
            }

            $complaint = $this->complaintsRepo->create([
                'user_id' => $user->id,
                'complaint_category_id' => $request['complaint_category_id'],
                'location_id' => $location_id,
                'title' => $request['title'],
                'description' => $request['description'] ?? null,
                'status' => 'انتظار',
            ]);

            if (!empty($complaintImages)) {
                $images = is_array($complaintImages) ? $complaintImages : [$complaintImages];
                $attachedImageIds = $this->storeImages($complaintImages);
                Log::info('Attached Image IDs: ' . implode(', ', $attachedImageIds)); // Add this log inf
                if (!empty($attachedImageIds)) {
                    $complaint->complaintImages()->attach($attachedImageIds, ['type' => 'complaint']);
                }
            }
            DB::commit();
            return ['complaint' => new ComplaintResource($complaint)];
        } catch (Exception $e) {
            DB::rollBack();
            if (isset($image)) {
                $this->imageRepo->deleteImagePlaceholder($image->id);
            }
            throw $e;
        }
    }

    public function updateComplaintStatus($id, array $request): array
    {
        $status = $request['status'] ?? null;
        $achievementImages = $request['achievementImages'] ?? [];
        $attachedImageIds = [];

        $complaint = $this->complaintsRepo->getComplaintById($id);
        if (!$complaint) {
            throw new \Exception('Complaint not found.');
        }

        if (!ComplaintStatus::isValid($status)) {
            throw new \InvalidArgumentException("Invalid status: $status");
        }

        DB::beginTransaction();
        try {
            if ($status == 'منجزة') {

                if (!empty($achievementImages)) {
                    $images = is_array($achievementImages) ? $achievementImages : [$achievementImages];
                    $attachedImageIds = $this->storeImages($achievementImages);
                    if (!empty($attachedImageIds)) {
                        $complaint->achievementImages()->attach($attachedImageIds, ['type' => 'achievement']);
                    }
                }
            }
            $complaint->update([
                'status' => $status,
            ]);
            DB::commit();
            return ['complaint' => new ComplaintResource($complaint)];
        } catch (\Exception $e) {
            // Clean up image placeholder if it was created
            foreach ($attachedImageIds as $imageId) {
                $this->imageRepo->deleteImagePlaceholder($imageId);
            }
            DB::rollBack();
            throw $e;
        }
    }

    private function storeImages(array $images): array
    {
        $attachedImageIds = [];

        foreach ($images as $imageFile) {
            if ($imageFile instanceof UploadedFile) {
                $image = $this->imageRepo->createPlaceholder();
                $this->imageRepo->storeTempImageAndDispatch($imageFile, $image->id);
                $attachedImageIds[] = $image->id;
            }
        }

        return $attachedImageIds;
    }


    public function getComplaintsByID($id): array
    {
        // Get complaint
        $complaint = $this->complaintsRepo->getComplaintById($id);
        if (!$complaint) {
            throw new \Exception('Complaint not found.');
        }
        return ['complaint' => new ComplaintResource($complaint)];
    }

    public function getComplaintCategories(): \Illuminate\Support\Collection
    {

        return $this->complaintsRepo->getComplaintCategories();
    }

    public function createComplaintCategory($name): ComplaintCategory
    {

        return $this->complaintsRepo->createComplaintCategory($name);
    }

    public function updateComplaintCategory($id, $name): ComplaintCategory
    {
        return $this->complaintsRepo->updateComplaintCategory($id, $name);
    }

    public function deleteComplaintCategory($id): void
    {
        $this->complaintsRepo->deleteComplaintCategory($id);
    }
}
