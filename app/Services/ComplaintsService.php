<?php

namespace App\Services;

use App\Enums\ComplaintStatus;
use App\Http\Resources\ComplaintResource;
use App\Models\ComplaintCategory;
use App\Repositories\ComplaintsRepository;
use App\Repositories\ImageRepository;
use App\Repositories\LocationRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\ComplaintScoringService;

class ComplaintsService
{
    public function __construct(
        private LocationRepository $locationRepo,
        private ImageRepository $imageRepo,
        private ComplaintsRepository $complaintsRepo,
        private ComplaintScoringService $pointsService
    ) {}

    public function getResponseDetails($complaints): array
    {
        $data = [
            'total' => $complaints->count(),
            'complaints' => $complaints,
            'complaint_categories' => $this->getComplaintCategories(),
            'regions' => $this->locationRepo->getAllRegion(),
        ];

        return $data;
    }

    public function filterComplaintsClient(array $filters): array
    {
        $complaints = $this->complaintsRepo->applyCommonFilters($filters);

        if (isset($filters['distance'])) {
            $complaints = $this->complaintsRepo->applyNearbyFilter($complaints, $filters['distance']);
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
        $complaints = $complaints->orderByDesc('priority_points')->get();
        $FullConlaints = $complaints->map(function ($complaint) {
            return new ComplaintResource($complaint);
        });

        return $this->getResponseDetails($FullConlaints);
    }

    public function createComplaint(array $request): array
    {
        $complaintImages = $request['complaintImages'] ?? [];
        $attachedImageIds = [];
        $title = $request['title'];
        $region=$request['region'];
        $description = $request['description'];
        $categoryId=$request['complaint_category_id'];
        DB::beginTransaction();

        try {
            $location_id = $this->locationRepo->create([
                'latitude' => $request['latitude'],
                'longitude' => $request['longitude'],
                'region' => $request['region'] ?? 'غير معروف',
            ]);

            $user = Auth::user();
            if (! $user) {
                throw new Exception('User not authenticated.');
            }

            $points=$this->pointsService->calculate($title, $description, $region, $categoryId);

            $complaint = $this->complaintsRepo->create([
                'user_id' => $user->id,
                'complaint_category_id' => $categoryId,
                'location_id' => $location_id,
                'region' => $request['region'] ,
                'title' => $title,
                'description' => $description ?? null,
                'status' => 'انتظار',
                'priority_points' => $points,
            ]);

            if (! empty($complaintImages)) {
                $images = is_array($complaintImages) ? $complaintImages : [$complaintImages];
                $attachedImageIds = $this->storeImages($complaintImages);
                Log::info('Attached Image IDs: '.implode(', ', $attachedImageIds)); // Add this log inf
                if (! empty($attachedImageIds)) {
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
        if (! $complaint) {
            throw new \Exception('Complaint not found.');
        }

        if (! ComplaintStatus::isValid($status)) {
            throw new \InvalidArgumentException("Invalid status: $status");
        }

        DB::beginTransaction();
        try {
            if ($status == 'منجزة') {

                if (! empty($achievementImages)) {
                    $images = is_array($achievementImages) ? $achievementImages : [$achievementImages];
                    $attachedImageIds = $this->storeImages($achievementImages);
                    if (! empty($attachedImageIds)) {
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
        if (! $complaint) {
            throw new \Exception('Complaint not found.');
        }

        return ['complaint' => new ComplaintResource($complaint)];
    }

    public function getComplaintCategories(): \Illuminate\Support\Collection
    {

        return $this->complaintsRepo->getComplaintCategories();
    }

    public function createComplaintCategory($name, $points = null): ComplaintCategory
    {
        $points = $points ?? 5; // fallback to 5 if null
        return $this->complaintsRepo->createComplaintCategory($name, $points);
    }

    public function updateComplaintCategory($id, $name): ComplaintCategory
    {
        return $this->complaintsRepo->updateComplaintCategory($id, $name);
    }

    public function deleteComplaintCategory($id): void
    {
        $this->complaintsRepo->deleteComplaintCategory($id);
    }

    public function updateComplaint($id, array $request): array
    {
        $complaint_images = $request['complaint_images'] ?? [];
        $attachedImageIds = [];

        $complaint = $this->complaintsRepo->getComplaintById($id);
        if (!$complaint) {
            throw new \Exception('Complaint not found.');
        }


        DB::beginTransaction();
        try {

                if (!empty($complaint_images)) {
                    $images = is_array($complaint_images) ? $complaint_images : [$complaint_images];
                    $attachedImageIds = $this->storeImages($complaint_images);
                    if (!empty($attachedImageIds)) {
                        $complaint->complaintImages()->attach($attachedImageIds, ['type' => 'complaint']);
                    }
                }
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
}
