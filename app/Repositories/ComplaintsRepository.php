<?php

namespace App\Repositories;

use App\Models\Complaint;
use Google\Service\Docs\Request;
use \Illuminate\Database\Eloquent\Collection;
use App\Models\ComplaintCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ComplaintsRepository
{

    protected const CACHE_ALL = 'complaints:all';
    protected const CACHE_STATUS = 'complaints:status:'; // append status
    protected const CACHE_CATEGORY = 'complaints:category:'; // append category_id
    protected const CACHE_CAT_STATUS = 'complaints:cat:status:'; // append category_id:status


    public function getAllComplaints(): Collection
    {
        return Cache::remember(self::CACHE_ALL, 3600, function () {
            return Complaint::all();
        });
    }

    public function create(array $data): Complaint
    {

        $this->clearComplaintCache();
        return  Complaint::create([
            'user_id' => $data['user_id'],
            'location_id' => $data['location_id'],
            'image_id' => ($data['image_id']),
            'complaint_category_id' => $data['complaint_category_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);
    }

    public function getComplaintsByStatus($status): Collection
    {
        $status_number=$this->setStatusNumber($status);
        $key = self::CACHE_STATUS .$status_number ;
        return Cache::remember($key, 3600, function () use ($status) {
            return Complaint::where('status', $status)->get();
        });
    }

    public function setStatusNumber($status)
    {
        switch ($status) {
            case 'انتظار':
                return 1;
            case 'تم التحقق':
                return 2;
            case 'مرفوضة':
                return 3;
            case 'يتم التنفيذ';
                return 4;
            case 'منجزة':
                return 5;
            case 'null':
                return 6;
            default:
                throw new \InvalidArgumentException('Invalid status: ' . $status);
        }
    }

    public function getComplaintsByCategory($category_id): Collection
    {
        $category = ComplaintCategory::find($category_id);
        if (!$category) {
            throw new \Exception('Category not found.');
        }

        $key = self::CACHE_CATEGORY . $category_id;

        return Cache::remember($key, 3600, function () use ($category_id) {
            return Complaint::where('complaint_category_id', $category_id)->get();
        });
    }

    public function getComplaintsByCatAndSt(array $request): Collection
    {
        $category_id = $request['category_id'];
        $status = $request['status'];
        $status_number=$this->setStatusNumber($status);

        $category = ComplaintCategory::find($category_id);
        if (!$category) {
            throw new \Exception('Category not found.');
        }

        $key = self::CACHE_CAT_STATUS . "$category_id:$status_number";

        return Cache::remember($key, 3600, function () use ($category_id, $status) {
            return Complaint::where('complaint_category_id', $category_id)
                ->where('status', $status)
                ->get();
        });
    }

    public function getComplaintById($id): Complaint
    {
        if (!$id) {
            throw new \Exception('Complaint ID is required.');
        }
        $complaint = Complaint::find($id);
        if (!$complaint) {
            throw new \Exception('Complaint not found.');
        }
        return $complaint;
    }

    public function getComplaintCategories(): Collection
    {
        return ComplaintCategory::select('id', 'name')->get();
    }

    public function createComplaintCategory($name): ComplaintCategory
    {
        return ComplaintCategory::create([
            'name' => $name,
        ]);
    }

    public function updateComplaintCategory($id, $name): ComplaintCategory
    {
        $category = ComplaintCategory::find($id);
        if (!$category) {
            throw new \Exception('Category not found.');
        }
        $category->name = $name;
        $category->save();
        return $category;
    }

    public function deleteComplaintCategory($id): bool
    {
        $category = ComplaintCategory::find($id);
        if (!$category) {
            throw new \Exception('Category not found.');
        }
        return $category->delete();
    }


    public function clearComplaintCache(): void
    {
        Cache::forget(self::CACHE_ALL);

        if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
            $redis = Cache::getRedis();
            $keys = $redis->keys('complaints:*');
            foreach ($keys as $key) {
                $redis->del($key);
            }
        }
    }

    public function getNearbyComplaints($latitude, $longitude, $distanceKm = 1000, $status = null, $categoryId = null):Collection
    {

        $status = $request['status'] ?? null;
        $categoryId = $request['category_id'] ?? null;

        $distanceFormula = "(6371 * acos(cos(radians($latitude)) * cos(radians(locations.latitude)) * cos(radians(locations.longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(locations.latitude))))";

        $query = Complaint::query()
            ->join('locations', 'complaints.location_id', '=', 'locations.id')
            ->select('complaints.*')
            ->whereRaw("$distanceFormula < ?", [$distanceKm]);



        if ($status) {
            $query->where('complaints.status', $status);
        }

        if ($categoryId) {
            $query->where('complaints.category_id', $categoryId);
        }

        return $query->get();
    }



}
