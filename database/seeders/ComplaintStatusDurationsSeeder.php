<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintStatusDurationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('complaint_status_durations')->insert([
            ['id'=>15,'complaint_id'=>1,'status'=>'تم التحقق','entered_at'=>'2025-08-14 10:10:09','left_at'=>'2025-08-14 07:10:09','created_at'=>'2025-08-14 07:05:39','updated_at'=>'2025-08-14 07:10:09'],
            ['id'=>16,'complaint_id'=>2,'status'=>'تم التحقق','entered_at'=>'2025-08-24 22:21:47','left_at'=>'2025-08-24 19:21:47','created_at'=>'2025-08-14 07:06:03','updated_at'=>'2025-08-24 19:21:47'],
            ['id'=>17,'complaint_id'=>3,'status'=>'تم التحقق','entered_at'=>'2025-08-14 10:10:12','left_at'=>'2025-08-14 07:10:12','created_at'=>'2025-08-14 07:06:08','updated_at'=>'2025-08-14 07:10:12'],
            ['id'=>18,'complaint_id'=>4,'status'=>'تم التحقق','entered_at'=>'2025-08-24 22:21:49','left_at'=>'2025-08-24 19:21:49','created_at'=>'2025-08-14 07:06:44','updated_at'=>'2025-08-24 19:21:49'],
            ['id'=>19,'complaint_id'=>5,'status'=>'تم التحقق','entered_at'=>'2025-08-14 10:10:14','left_at'=>'2025-08-14 07:10:14','created_at'=>'2025-08-14 07:06:46','updated_at'=>'2025-08-14 07:10:14'],
            ['id'=>20,'complaint_id'=>6,'status'=>'تم التحقق','entered_at'=>'2025-08-24 22:21:56','left_at'=>'2025-08-24 19:21:56','created_at'=>'2025-08-14 07:06:48','updated_at'=>'2025-08-24 19:21:56'],
            ['id'=>21,'complaint_id'=>7,'status'=>'تم التحقق','entered_at'=>'2025-08-14 10:11:46','left_at'=>'2025-08-14 07:11:46','created_at'=>'2025-08-14 07:07:49','updated_at'=>'2025-08-14 07:11:46'],
            ['id'=>22,'complaint_id'=>8,'status'=>'تم التحقق','entered_at'=>'2025-08-24 22:21:58','left_at'=>'2025-08-24 19:21:58','created_at'=>'2025-08-14 07:07:50','updated_at'=>'2025-08-24 19:21:58'],
            ['id'=>23,'complaint_id'=>9,'status'=>'تم التحقق','entered_at'=>'2025-08-14 10:11:51','left_at'=>'2025-08-14 07:11:51','created_at'=>'2025-08-14 07:08:15','updated_at'=>'2025-08-14 07:11:51'],
            ['id'=>24,'complaint_id'=>10,'status'=>'تم التحقق','entered_at'=>'2025-08-24 22:22:01','left_at'=>'2025-08-24 19:22:01','created_at'=>'2025-08-14 07:08:18','updated_at'=>'2025-08-24 19:22:01'],
            ['id'=>25,'complaint_id'=>1,'status'=>'تم التعيين','entered_at'=>'2025-08-14 10:15:27','left_at'=>'2025-08-14 07:15:27','created_at'=>'2025-08-14 07:10:09','updated_at'=>'2025-08-14 07:15:27'],
            ['id'=>26,'complaint_id'=>3,'status'=>'تم التعيين','entered_at'=>'2025-08-14 10:15:29','left_at'=>'2025-08-14 07:15:29','created_at'=>'2025-08-14 07:10:12','updated_at'=>'2025-08-14 07:15:29'],
            ['id'=>27,'complaint_id'=>5,'status'=>'تم التعيين','entered_at'=>'2025-08-14 10:15:30','left_at'=>'2025-08-14 07:15:30','created_at'=>'2025-08-14 07:10:14','updated_at'=>'2025-08-14 07:15:30'],
            ['id'=>28,'complaint_id'=>7,'status'=>'تم التعيين','entered_at'=>'2025-08-14 07:11:46','left_at'=>null,'created_at'=>'2025-08-14 07:11:46','updated_at'=>'2025-08-14 07:11:46'],
            ['id'=>29,'complaint_id'=>9,'status'=>'تم التعيين','entered_at'=>'2025-08-14 07:11:51','left_at'=>null,'created_at'=>'2025-08-14 07:11:51','updated_at'=>'2025-08-14 07:11:51'],
            ['id'=>30,'complaint_id'=>1,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-14 10:19:01','left_at'=>'2025-08-14 07:19:01','created_at'=>'2025-08-14 07:15:27','updated_at'=>'2025-08-14 07:19:01'],
            ['id'=>31,'complaint_id'=>3,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-14 10:22:32','left_at'=>'2025-08-14 07:22:32','created_at'=>'2025-08-14 07:15:29','updated_at'=>'2025-08-14 07:22:32'],
            ['id'=>32,'complaint_id'=>5,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-14 07:15:30','left_at'=>null,'created_at'=>'2025-08-14 07:15:30','updated_at'=>'2025-08-14 07:15:30'],
            ['id'=>33,'complaint_id'=>1,'status'=>'منجزة','entered_at'=>'2025-08-14 07:19:01','left_at'=>null,'created_at'=>'2025-08-14 07:19:01','updated_at'=>'2025-08-14 07:19:01'],
            ['id'=>34,'complaint_id'=>3,'status'=>'منجزة','entered_at'=>'2025-08-14 10:23:12','left_at'=>'2025-08-14 07:23:12','created_at'=>'2025-08-14 07:22:32','updated_at'=>'2025-08-14 07:23:12'],
            ['id'=>35,'complaint_id'=>3,'status'=>'مغلقة','entered_at'=>'2025-08-14 07:23:12','left_at'=>null,'created_at'=>'2025-08-14 07:23:12','updated_at'=>'2025-08-14 07:23:12'],
            ['id'=>36,'complaint_id'=>11,'status'=>'تم التعيين','entered_at'=>'2025-08-24 22:25:28','left_at'=>'2025-08-24 19:25:28','created_at'=>'2025-08-24 19:21:27','updated_at'=>'2025-08-24 19:25:28'],
            ['id'=>37,'complaint_id'=>12,'status'=>'تم التعيين','entered_at'=>'2025-08-24 19:21:36','left_at'=>null,'created_at'=>'2025-08-24 19:21:36','updated_at'=>'2025-08-24 19:21:36'],
            ['id'=>38,'complaint_id'=>1,'status'=>'تم التعيين','entered_at'=>'2025-08-24 22:23:53','left_at'=>'2025-08-24 19:23:53','created_at'=>'2025-08-24 19:21:44','updated_at'=>'2025-08-24 19:23:53'],
            ['id'=>39,'complaint_id'=>2,'status'=>'تم التعيين','entered_at'=>'2025-08-24 19:21:47','left_at'=>null,'created_at'=>'2025-08-24 19:21:47','updated_at'=>'2025-08-24 19:21:47'],
            ['id'=>40,'complaint_id'=>3,'status'=>'تم التعيين','entered_at'=>'2025-08-24 22:24:01','left_at'=>'2025-08-24 19:24:01','created_at'=>'2025-08-24 19:21:48','updated_at'=>'2025-08-24 19:24:01'],
            ['id'=>41,'complaint_id'=>4,'status'=>'تم التعيين','entered_at'=>'2025-08-24 22:28:52','left_at'=>'2025-08-24 19:28:52','created_at'=>'2025-08-24 19:21:49','updated_at'=>'2025-08-24 19:28:52'],
            ['id'=>42,'complaint_id'=>5,'status'=>'تم التعيين','entered_at'=>'2025-08-24 22:24:04','left_at'=>'2025-08-24 19:24:04','created_at'=>'2025-08-24 19:21:50','updated_at'=>'2025-08-24 19:24:04'],
            ['id'=>43,'complaint_id'=>6,'status'=>'تم التعيين','entered_at'=>'2025-08-24 19:21:56','left_at'=>null,'created_at'=>'2025-08-24 19:21:56','updated_at'=>'2025-08-24 19:21:56'],
            ['id'=>44,'complaint_id'=>7,'status'=>'تم التعيين','entered_at'=>'2025-08-24 22:25:23','left_at'=>'2025-08-24 19:25:23','created_at'=>'2025-08-24 19:21:57','updated_at'=>'2025-08-24 19:25:23'],
            ['id'=>45,'complaint_id'=>8,'status'=>'تم التعيين','entered_at'=>'2025-08-24 19:21:58','left_at'=>null,'created_at'=>'2025-08-24 19:21:58','updated_at'=>'2025-08-24 19:21:58'],
            ['id'=>46,'complaint_id'=>9,'status'=>'تم التعيين','entered_at'=>'2025-08-24 22:25:25','left_at'=>'2025-08-24 19:25:25','created_at'=>'2025-08-24 19:21:59','updated_at'=>'2025-08-24 19:25:25'],
            ['id'=>47,'complaint_id'=>10,'status'=>'تم التعيين','entered_at'=>'2025-08-24 19:22:01','left_at'=>null,'created_at'=>'2025-08-24 19:22:01','updated_at'=>'2025-08-24 19:22:01'],
            ['id'=>48,'complaint_id'=>13,'status'=>'تم التعيين','entered_at'=>'2025-08-24 22:25:31','left_at'=>'2025-08-24 19:25:31','created_at'=>'2025-08-24 19:22:38','updated_at'=>'2025-08-24 19:25:31'],
            ['id'=>49,'complaint_id'=>14,'status'=>'تم التعيين','entered_at'=>'2025-08-24 19:22:39','left_at'=>null,'created_at'=>'2025-08-24 19:22:39','updated_at'=>'2025-08-24 19:22:39'],
            ['id'=>50,'complaint_id'=>15,'status'=>'تم التعيين','entered_at'=>'2025-08-24 22:25:35','left_at'=>'2025-08-24 19:25:35','created_at'=>'2025-08-24 19:22:40','updated_at'=>'2025-08-24 19:25:35'],
            ['id'=>51,'complaint_id'=>16,'status'=>'تم التعيين','entered_at'=>'2025-08-24 19:22:41','left_at'=>null,'created_at'=>'2025-08-24 19:22:41','updated_at'=>'2025-08-24 19:22:41'],
            ['id'=>52,'complaint_id'=>1,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-24 22:26:29','left_at'=>'2025-08-24 19:26:29','created_at'=>'2025-08-24 19:23:53','updated_at'=>'2025-08-24 19:26:29'],
            ['id'=>53,'complaint_id'=>3,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-24 22:26:49','left_at'=>'2025-08-24 19:26:49','created_at'=>'2025-08-24 19:24:01','updated_at'=>'2025-08-24 19:26:49'],
            ['id'=>54,'complaint_id'=>5,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-24 19:24:04','left_at'=>null,'created_at'=>'2025-08-24 19:24:04','updated_at'=>'2025-08-24 19:24:04'],
            ['id'=>55,'complaint_id'=>7,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-24 19:25:23','left_at'=>null,'created_at'=>'2025-08-24 19:25:23','updated_at'=>'2025-08-24 19:25:23'],
            ['id'=>56,'complaint_id'=>9,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-24 19:25:25','left_at'=>null,'created_at'=>'2025-08-24 19:25:25','updated_at'=>'2025-08-24 19:25:25'],
            ['id'=>57,'complaint_id'=>11,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-24 19:25:28','left_at'=>null,'created_at'=>'2025-08-24 19:25:28','updated_at'=>'2025-08-24 19:25:28'],
            ['id'=>58,'complaint_id'=>13,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-24 19:25:31','left_at'=>null,'created_at'=>'2025-08-24 19:25:31','updated_at'=>'2025-08-24 19:25:31'],
            ['id'=>59,'complaint_id'=>15,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-24 19:25:35','left_at'=>null,'created_at'=>'2025-08-24 19:25:35','updated_at'=>'2025-08-24 19:25:35'],
            ['id'=>60,'complaint_id'=>1,'status'=>'منجزة','entered_at'=>'2025-08-24 19:26:29','left_at'=>null,'created_at'=>'2025-08-24 19:26:29','updated_at'=>'2025-08-24 19:26:29'],
            ['id'=>61,'complaint_id'=>3,'status'=>'منجزة','entered_at'=>'2025-08-24 19:26:49','left_at'=>null,'created_at'=>'2025-08-24 19:26:49','updated_at'=>'2025-08-24 19:26:49'],
            ['id'=>62,'complaint_id'=>4,'status'=>'يتم التنفيذ','entered_at'=>'2025-08-24 22:29:09','left_at'=>'2025-08-24 19:29:09','created_at'=>'2025-08-24 19:28:52','updated_at'=>'2025-08-24 19:29:09'],
            ['id'=>63,'complaint_id'=>4,'status'=>'منجزة','entered_at'=>'2025-08-24 19:29:09','left_at'=>null,'created_at'=>'2025-08-24 19:29:09','updated_at'=>'2025-08-24 19:29:09'],
            ['id'=>64,'complaint_id'=>14,'status'=>'مرفوضة','entered_at'=>'2025-08-24 19:30:48','left_at'=>null,'created_at'=>'2025-08-24 19:30:48','updated_at'=>'2025-08-24 19:30:48'],
            ['id'=>65,'complaint_id'=>16,'status'=>'مرفوضة','entered_at'=>'2025-08-24 19:31:33','left_at'=>null,'created_at'=>'2025-08-24 19:31:33','updated_at'=>'2025-08-24 19:31:33'],
        ]);
    }
}
