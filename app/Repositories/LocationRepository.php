<?php

namespace App\Repositories;

use App\Models\Location;
use Illuminate\Support\Facades\DB;
use App\Models\Region;

class LocationRepository
{
    public function create(array $data): int
    {
        return DB::table('locations')->insertGetId([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'name' => $data['region'] ?? 'غير معروف',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


    public function getAllLocations()
{
    return Location::select('id', 'name')
        ->get()
        ->map(function ($location) {
            return [
                'location_id' => $location->id,
                'name' => $location->name,
            ];
        });
}

    public function update(array $data, int $locationId): int
    {
        $location = Location::findOrFail($locationId);

        $location->update([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'name' => $data['area'] ?? $location->name, // keep current name if not provided
        ]);

        return $location->id;
    }

    public function getRegion($region)
    {
        return Region::where('name', $region)->firstOrFail();
    }
    public function getAllRegion()
    {
        return Region::select('id as region_id', 'name')->get();
    }
}
