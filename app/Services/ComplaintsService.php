<?php

namespace App\Services;

use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Repositories\LocationRepository;
use App\Repositories\ImageRepository;
use App\Repositories\ComplaintsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\ComplaintStatus;
use Illuminate\Http\UploadedFile;
use  Exception;
use Illuminate\Support\Facades\Log;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use App\Models\User;

class ComplaintsService
{
    public function __construct(
        private LocationRepository $locationRepo,
        private ImageRepository $imageRepo,
        private ComplaintsRepository $complaintsRepo,
    ) {}

    public function getFullComplaint(Complaint $complaint)
    {
        $data = [
            'id' => $complaint->id,
            'title' => $complaint->title,
            'description' => $complaint->description,
            'status' => $complaint->status,
            'created_at' => $complaint->created_at,
            'user' => [
                'userID' => $complaint->user?->id,
                'created_by' => $complaint->user?->name,
                'role' => $complaint->user?->getRoleNames()[0] ?? null,
            ],
            'image_url' => $complaint->image?->image_url,
            'category' => $complaint->category?->name,
            'location' => [
                'name' => $complaint->location?->name,
                'latitude' => $complaint->location?->latitude,
                'longitude' => $complaint->location?->longitude,
            ],
            'achievement_images' => $complaint->achievementImages->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $image->image_url,
                ];
            }),
        ];

        return $data;
    }


    public function getAllComplaints()
    {
        $complaints = $this->complaintsRepo->getAllComplaints();

        return $complaints->map(function ($complaint) {
            return $this->getFullComplaint($complaint);
        });
    }

    public function getComplaintsByCategory($category_id)
    {
        if (!$category_id) {
            throw new \Exception('Category ID is required.');
        }
        $complaints = $this->complaintsRepo->getComplaintsByCategory($category_id);
        return $complaints->map(function ($complaint) {
            return $this->getFullComplaint($complaint);
        });
    }

    public function getComplaintsByStatus($status)
    {
        if (!$status) {
            throw new \Exception('Status is required.');
        }
        $complaints = $this->complaintsRepo->getComplaintsByStatus($status);
        return $complaints->map(function ($complaint) {
            return $this->getFullComplaint($complaint);
        });
    }

    public function getComplaintsByCatAndSt(array $request)
    {
        if (!$request['category_id']) {
            throw new \Exception('Category ID is required.');
        }
        if (!$request['status']) {
            throw new \Exception('Status is required.');
        }

        $complaints = $this->complaintsRepo->getComplaintsByCatAndSt($request);
        return $complaints->map(function ($complaint) {
            return $this->getFullComplaint($complaint);
        });
    }

    public function getNearbyComplaints(array $request)
    {
        $user = User::where('id', Auth::id())->with('clientProfile.location')->first();

        if (! $user || ! optional($user->clientProfile->location)->latitude || ! optional($user->clientProfile->location)->longitude) {
            throw new Exception('User location not set.');
        }

        $status = $request['status'] ?? null;
        $categoryId = $request['category_id'] ?? null; // corrected typo 'categoru_id' -> 'category_id'
        $distance = $request['distance'] ?? 10; // optional: default to 10 km

        $latitude = $user->clientProfile->location->latitude;
        $longitude = $user->clientProfile->location->longitude;

        $complaints = $this->complaintsRepo->getNearbyComplaints($latitude, $longitude, $distance, $status, $categoryId);

        return $complaints->map(function ($complaint) {
            return $this->getFullComplaint($complaint);
        });
    }

    public function createComplaint(array $request)
    {
        DB::beginTransaction();

        try {
            $location = $this->locationRepo->create([
                'latitude' => $request['latitude'],
                'longitude' => $request['longitude'],
                'area' => $request['area'] ?? 'غير معروف',
            ]);

            $image = DB::transaction(function () {
                return $this->imageRepo->createPlaceholder();
            });

            $user = Auth::user();
            if (!$user) {
                throw new Exception('User not authenticated.');
            }

            $complaint = $this->complaintsRepo->create([
                'user_id' => $user->id,
                'complaint_category_id' => $request['complaint_category_id'],
                'location_id' => $location,
                'image_id' => $image->id,
                'title' => $request['title'],
                'description' => $request['description'] ?? null,
                'status' => 'انتظار',
            ]);

            DB::commit();

            if (isset($request['image'])) {
                $this->imageRepo->storeTempImageAndDispatch($request['image'], $image->id);
            }

            return $this->getFullComplaint($complaint);
        } catch (Exception $e) {
            DB::rollBack();

            if (isset($image)) {
                $this->imageRepo->deleteImagePlaceholder($image->id);
            }
            throw $e;
        }
    }

    public function updateComplaintStatus($id, array $request)
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

                    foreach ($images as $imageFile) {
                        if ($imageFile instanceof UploadedFile) {
                            $image = $this->imageRepo->createPlaceholder(); // Save temp row in images table
                            $this->imageRepo->storeTempImageAndDispatch($imageFile, $image->id);

                            $attachedImageIds[] = $image->id;
                        }
                    }

                    if (!empty($attachedImageIds)) {
                        log::info('asdasd');
                        $complaint->achievementImages()->attach($attachedImageIds);
                    }
                }
            }

            $complaint->update([
                'status' => $status,
            ]);

            $this->complaintsRepo->clearComplaintCache();
            DB::commit();
            return $this->getFullComplaint($complaint);
        } catch (\Exception $e) {
            // Clean up image placeholder if it was created
            foreach ($attachedImageIds as $imageId) {
                $this->imageRepo->deleteImagePlaceholder($imageId);
            }
            DB::rollBack();
            throw $e;
        }
    }

    public function getComplaintsByID($id)
    {
        // Get complaint
        $complaint = $this->complaintsRepo->getComplaintById($id);
        if (!$complaint) {
            throw new \Exception('Complaint not found.');
        }
        return $this->getFullComplaint($complaint);
    }

    public function getComplaintCategories(): collection
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

    public function getFormalBook($id)
    {
        $complaint = $this->complaintsRepo->getComplaintById($id);
        if (!$complaint) {
            throw new \Exception('Complaint not found.');
        }
        $html = view('complaints.pdf', ['complaint' => $complaint])->render();
        return $html; // Return the rendered view as a string or nul
    }

    public function downloadFormalBook($id)
    {
        $complaint = $this->complaintsRepo->getComplaintById($id);
        if (!$complaint) {
            throw new \Exception('Complaint not found.');
        }



        $data = [
            'name' => $complaint->user->name,
            'complaint_title' => $complaint->title,
            'complaint_description' => $complaint->description,
            'complaint_location' => $complaint->location->name,
            'phone' => $complaint->user->clientProfile->phone,
        ];

        if ($complaint->image && $complaint->image->image_url) {
            $data['image_url'] = $complaint->image->image_url; // Correct syntax here
        }


        $pdf = PDF::loadView('complaints.pdf', compact('data'), [], [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'amiri',
            'orientation' => 'P',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'mirrorMargins' => true,
            'default_font_size' => 12,
            'directionality' => 'rtl',
            'autoScriptToLang' => true,
            'autoLangToFont' => true
        ]);



        return $pdf;
    }
}
