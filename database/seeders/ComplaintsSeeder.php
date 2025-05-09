<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComplaintCategory;

class ComplaintsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = [
            'نظافة',
            'صيانة',
            'انارة',
            'كهرباء',
            'صرف صحي',
            'مياه',
            'ارصفة و طرقات',
            'أخرى',
        ];

        foreach($categories as $category)
        {
            ComplaintCategory::create([
                'name' => $category,
            ]);
        }


    }
}
