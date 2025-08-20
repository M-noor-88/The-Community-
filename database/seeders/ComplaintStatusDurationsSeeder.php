<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintStatusDurationsSeeder extends Seeder
{
    public function run()
    {
        DB::table('complaint_status_durations')->insert([
            ['id' => 15, 'complaint_id' => 1, 'status' => 'تم التحقق', 'entered_at' => '2025-08-14 13:10:09', 'left_at' => '2025-08-14 10:10:09', 'created_at' => '2025-08-14 10:05:39', 'updated_at' => '2025-08-14 10:10:09'],
            ['id' => 16, 'complaint_id' => 2, 'status' => 'تم التحقق', 'entered_at' => '2025-08-14 10:06:03', 'left_at' => null, 'created_at' => '2025-08-14 10:06:03', 'updated_at' => '2025-08-14 10:06:03'],
            ['id' => 17, 'complaint_id' => 3, 'status' => 'تم التحقق', 'entered_at' => '2025-08-14 13:10:12', 'left_at' => '2025-08-14 10:10:12', 'created_at' => '2025-08-14 10:06:08', 'updated_at' => '2025-08-14 10:10:12'],
            ['id' => 18, 'complaint_id' => 4, 'status' => 'تم التحقق', 'entered_at' => '2025-08-14 10:06:44', 'left_at' => null, 'created_at' => '2025-08-14 10:06:44', 'updated_at' => '2025-08-14 10:06:44'],
            ['id' => 19, 'complaint_id' => 5, 'status' => 'تم التحقق', 'entered_at' => '2025-08-14 13:10:14', 'left_at' => '2025-08-14 10:10:14', 'created_at' => '2025-08-14 10:06:46', 'updated_at' => '2025-08-14 10:10:14'],
            ['id' => 20, 'complaint_id' => 6, 'status' => 'تم التحقق', 'entered_at' => '2025-08-14 10:06:48', 'left_at' => null, 'created_at' => '2025-08-14 10:06:48', 'updated_at' => '2025-08-14 10:06:48'],
            ['id' => 21, 'complaint_id' => 7, 'status' => 'تم التحقق', 'entered_at' => '2025-08-14 13:11:46', 'left_at' => '2025-08-14 10:11:46', 'created_at' => '2025-08-14 10:07:49', 'updated_at' => '2025-08-14 10:11:46'],
            ['id' => 22, 'complaint_id' => 8, 'status' => 'تم التحقق', 'entered_at' => '2025-08-14 10:07:50', 'left_at' => null, 'created_at' => '2025-08-14 10:07:50', 'updated_at' => '2025-08-14 10:07:50'],
            ['id' => 23, 'complaint_id' => 9, 'status' => 'تم التحقق', 'entered_at' => '2025-08-14 13:11:51', 'left_at' => '2025-08-14 10:11:51', 'created_at' => '2025-08-14 10:08:15', 'updated_at' => '2025-08-14 10:11:51'],
            ['id' => 24, 'complaint_id' => 10, 'status' => 'تم التحقق', 'entered_at' => '2025-08-14 10:08:18', 'left_at' => null, 'created_at' => '2025-08-14 10:08:18', 'updated_at' => '2025-08-14 10:08:18'],
            ['id' => 25, 'complaint_id' => 1, 'status' => 'تم التعيين', 'entered_at' => '2025-08-14 13:15:27', 'left_at' => '2025-08-14 10:15:27', 'created_at' => '2025-08-14 10:10:09', 'updated_at' => '2025-08-14 10:15:27'],
            ['id' => 26, 'complaint_id' => 3, 'status' => 'تم التعيين', 'entered_at' => '2025-08-14 13:15:29', 'left_at' => '2025-08-14 10:15:29', 'created_at' => '2025-08-14 10:10:12', 'updated_at' => '2025-08-14 10:15:29'],
            ['id' => 27, 'complaint_id' => 5, 'status' => 'تم التعيين', 'entered_at' => '2025-08-14 13:15:30', 'left_at' => '2025-08-14 10:15:30', 'created_at' => '2025-08-14 10:10:14', 'updated_at' => '2025-08-14 10:15:30'],
            ['id' => 28, 'complaint_id' => 7, 'status' => 'تم التعيين', 'entered_at' => '2025-08-14 10:11:46', 'left_at' => null, 'created_at' => '2025-08-14 10:11:46', 'updated_at' => '2025-08-14 10:11:46'],
            ['id' => 29, 'complaint_id' => 9, 'status' => 'تم التعيين', 'entered_at' => '2025-08-14 10:11:51', 'left_at' => null, 'created_at' => '2025-08-14 10:11:51', 'updated_at' => '2025-08-14 10:11:51'],
            ['id' => 30, 'complaint_id' => 1, 'status' => 'يتم التنفيذ', 'entered_at' => '2025-08-14 13:19:01', 'left_at' => '2025-08-14 10:19:01', 'created_at' => '2025-08-14 10:15:27', 'updated_at' => '2025-08-14 10:19:01'],
            ['id' => 31, 'complaint_id' => 3, 'status' => 'يتم التنفيذ', 'entered_at' => '2025-08-14 13:22:32', 'left_at' => '2025-08-14 10:22:32', 'created_at' => '2025-08-14 10:15:29', 'updated_at' => '2025-08-14 10:22:32'],
            ['id' => 32, 'complaint_id' => 5, 'status' => 'يتم التنفيذ', 'entered_at' => '2025-08-14 10:15:30', 'left_at' => null, 'created_at' => '2025-08-14 10:15:30', 'updated_at' => '2025-08-14 10:15:30'],
            ['id' => 33, 'complaint_id' => 1, 'status' => 'منجزة', 'entered_at' => '2025-08-14 10:19:01', 'left_at' => null, 'created_at' => '2025-08-14 10:19:01', 'updated_at' => '2025-08-14 10:19:01'],
            ['id' => 34, 'complaint_id' => 3, 'status' => 'منجزة', 'entered_at' => '2025-08-14 13:23:12', 'left_at' => '2025-08-14 10:23:12', 'created_at' => '2025-08-14 10:22:32', 'updated_at' => '2025-08-14 10:23:12'],
            ['id' => 35, 'complaint_id' => 3, 'status' => 'مغلقة', 'entered_at' => '2025-08-14 10:23:12', 'left_at' => null, 'created_at' => '2025-08-14 10:23:12', 'updated_at' => '2025-08-14 10:23:12'],
        ]);
    }
}
