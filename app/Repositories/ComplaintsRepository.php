<?php

namespace App\Repositories;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ComplaintsRepository
{
    public function create(array $data): Complaint
    {
        return Complaint::create([
            'user_id' => $data['user_id'],
            'location_id' => $data['location_id'],
            'complaint_category_id' => $data['complaint_category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
        ]);
    }

    public function applyCommonFilters(array $filters): Builder
    {
        $query = Complaint::query();

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

        if (! empty($filters['location_id'])) {
            if (! Location::where('id', $filters['location_id'])->exists()) {
                throw new \InvalidArgumentException("Invalid location ID: {$filters['location_id']}");
            }
            $query->where('location_id', $filters['location_id']);
        }

        return $query;
    }

    public function applyNearbyFilter($query, int $distance = 100): Builder
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
            ->select('complaints.*') // ✅ force correct columns
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
        return ComplaintCategory::select('id', 'name')
            ->get()
            ->map(function ($category) {
                return [
                    'category_id' => $category->id,
                    'name' => $category->name,
                ];
            });
    }

    public function createComplaintCategory($name): ComplaintCategory
    {
        return ComplaintCategory::create([
            'name' => $name,
        ]);
    }

    public function updateComplaintCategory($id, $name): ComplaintCategory
    {
        $category = ComplaintCategory::findOrFail($id);
        $category->name = $name;
        $category->save();

        return $category;
    }

    public function deleteComplaintCategory($id): bool
    {
        $category = ComplaintCategory::findOrFail($id);

        return $category->delete();
    }
}
