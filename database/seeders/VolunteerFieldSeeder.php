<?php

namespace Database\Seeders;

use App\Models\VolunteerField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VolunteerFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = ['ترميم بيوت', 'توزيع مساعدات', 'تنظيم فعالية', 'اغاثة كوارث', 'مساعدات الطريق', 'تنظيف البيئة'];

        foreach ($fields as $field) {
            VolunteerField::firstOrCreate(['name' => $field]);
        }
    }
}
