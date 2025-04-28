<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationAndImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'name' => "somewhere",
            'longitude' => 43.222221434235,
            'latitude'=> 54.324093242893,
        ]);

        Image::create([
            'image_url' => "http://just-fake-url"
        ]);
    }
}
