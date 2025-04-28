<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

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
}
