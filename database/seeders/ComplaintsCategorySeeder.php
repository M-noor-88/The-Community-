<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComplaintCategory;
use Illuminate\Support\Facades\DB;

class ComplaintsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('complaint_categories')->insert([

        ['name' => 'نظافة', 'points' => 4],
        ['name' => 'صيانة', 'points' => 6],
        ['name' => 'انارة', 'points' => 5],
        ['name' => 'كهرباء', 'points' => 7],
        ['name' => 'صرف صحي', 'points' => 8],
        ['name' => 'مياه', 'points' => 6],
        ['name' => 'ارصفة و طرقات', 'points' => 5],
        ['name' => 'أخرى', 'points' => 2],
        ]);


    }
}
