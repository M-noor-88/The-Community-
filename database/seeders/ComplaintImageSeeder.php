<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintImageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('complaint_images')->insert([
            ['id' => 1, 'complaint_id' => 6, 'image_id' => 2, 'type' => 'complaint'],
            ['id' => 2, 'complaint_id' => 7, 'image_id' => 3, 'type' => 'complaint'],
            ['id' => 3, 'complaint_id' => 8, 'image_id' => 4, 'type' => 'complaint'],
            ['id' => 4, 'complaint_id' => 9, 'image_id' => 5, 'type' => 'complaint'],
            ['id' => 5, 'complaint_id' => 9, 'image_id' => 6, 'type' => 'complaint'],
            ['id' => 8, 'complaint_id' => 1, 'image_id' => 12, 'type' => 'complaint'],
            ['id' => 9, 'complaint_id' => 2, 'image_id' => 13, 'type' => 'complaint'],
            ['id' => 10, 'complaint_id' => 3, 'image_id' => 14, 'type' => 'complaint'],
            ['id' => 11, 'complaint_id' => 4, 'image_id' => 15, 'type' => 'complaint'],
            ['id' => 12, 'complaint_id' => 5, 'image_id' => 16, 'type' => 'complaint'],
            ['id' => 13, 'complaint_id' => 6, 'image_id' => 17, 'type' => 'complaint'],
            ['id' => 14, 'complaint_id' => 7, 'image_id' => 18, 'type' => 'complaint'],
            ['id' => 15, 'complaint_id' => 8, 'image_id' => 19, 'type' => 'complaint'],
            ['id' => 16, 'complaint_id' => 9, 'image_id' => 20, 'type' => 'complaint'],
            ['id' => 17, 'complaint_id' => 9, 'image_id' => 21, 'type' => 'complaint'],
            ['id' => 18, 'complaint_id' => 10, 'image_id' => 22, 'type' => 'complaint'],
            ['id' => 22, 'complaint_id' => 2, 'image_id' => 26, 'type' => 'achievement'],
        ]);
    }
}
