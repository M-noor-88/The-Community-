<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Location;

class LocationRepository
{
    public function create(array $data): int
    {
        return DB::table('locations')->insertGetId([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'name' => $data['area'] ?? 'غير معروف',
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

}
