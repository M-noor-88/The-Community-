<?php

namespace App\Repositories;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\Location;
use App\Models\User;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ComplaintsRepository
{
    public function create(array $data): Complaint
    {
        return Complaint::create([
            'user_id' => $data['user_id'],
            'location_id' => $data['location_id'],
            'region' => $data['area'],
            'complaint_category_id' => $data['complaint_category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'priority_points' => $data['priority_points'],
        ]);
    }

    public function applyCommonFilters(array $filters): Builder
    {
        $query = Complaint::query();
        $user = Auth::user();

        if (! empty($filters['status'])) {
            if (! ComplaintStatus::isValid($filters['status'])) {
                throw new \InvalidArgumentException("Invalid status: {$filters['status']}");
            }
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['category_id'])) {
            if (! ComplaintCategory::where('id', $filters['category_id'])->exists()) {
                throw new \InvalidArgumentException("Invalid category ID: {$filters['category_id']}");
            }
            $query->where('complaint_category_id', $filters['category_id']);
        }

        if (!empty($filters['region'])) {
            if(!Region::where('name', $filters['region'])->exists()){
                throw new \InvalidArgumentException("Invalid region : {$filters['region']}");
            }
            $query->where('region', $filters['region']);
        }

        if (isset($filters['userComplaints']) && $filters['userComplaints'] == 1) {
            $userId = Auth::id();
            if (!Complaint::where('user_id', $userId)->exists()) {
                throw new \InvalidArgumentException("No complaints found for the authenticated user.");
            }
            $query->where('user_id', $userId);
        }

        if ($user->hasRole('field_agent') && !empty($filters['status']) &&($filters['status']=='يتم التنفيذ'|| $filters['status']=='تم التعيين')) {
            $query->where('assigned_to', $user->id);
        }



        return $query;
    }

    public function applyNearbyFilter($query, $distance ): Builder
    {
        $user = Auth::user();
        if ($user) {
            $user = User::with('clientProfile.location')->find($user->id);
        }

        if (! $user || ! $user->clientProfile || ! $user->clientProfile->location) {
            throw new \Exception('User location not set.');
        }

        $latitude = $user->clientProfile->location->latitude;
        $longitude = $user->clientProfile->location->longitude;

        return $query->join('locations', 'complaints.location_id', '=', 'locations.id')
        ->select('complaints.*')
            ->whereRaw(
                '(6371 * acos(
                    cos(radians(?)) * cos(radians(locations.latitude)) *
                    cos(radians(locations.longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(locations.latitude))
                )) <= ?',
                [$latitude, $longitude, $latitude, $distance]
            );
    }

    public function getComplaintById($id): Complaint
    {
        if (! $id) {
            throw new \Exception('Complaint ID is required.');
        }
        $complaint = Complaint::find($id);

        if (! $complaint) {
            throw new \Exception('Complaint not found.');
        }

        return $complaint;
    }

    public function getComplaintCategories(): Collection
    {
        return ComplaintCategory::select('id', 'name', 'points')
            ->get()
            ->map(function ($category) {
                return [
                    'category_id' => $category->id,
                    'name' => $category->name,
                    'points' => $category->points,
                ];
            });
    }

    public function createComplaintCategory($name, $points): ComplaintCategory
    {
        return ComplaintCategory::create([
            'name' => $name,
            'points' => $points,
        ]);
    }

    public function updateComplaintCategory($id, $name, $points = null): ComplaintCategory
    {
        $category = ComplaintCategory::findOrFail($id);
        if($name){
            $category->name = $name;
        }
        if($points){
            $category->points = $points;
        }
        $category->save();

        return $category;
    }

    public function deleteComplaintCategory($id): bool
    {
        $category = ComplaintCategory::findOrFail($id);

        return $category->delete();
    }

    public function getComplaintCategoryById($id): ComplaintCategory
    {
        return ComplaintCategory::findOrFail($id);
    }

    public function countUserComplaintsThisMonth(int $userId): int
    {
        return Complaint::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

}
