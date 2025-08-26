<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintImageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('complaint_images')->insert([
            ['id'=>1,'complaint_id'=>1,'image_id'=>12,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>2,'complaint_id'=>2,'image_id'=>13,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>3,'complaint_id'=>3,'image_id'=>14,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>4,'complaint_id'=>4,'image_id'=>15,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>5,'complaint_id'=>5,'image_id'=>16,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>6,'complaint_id'=>6,'image_id'=>2,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>7,'complaint_id'=>7,'image_id'=>3,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>8,'complaint_id'=>8,'image_id'=>4,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>9,'complaint_id'=>9,'image_id'=>5,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>20,'complaint_id'=>9,'image_id'=>60,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>10,'complaint_id'=>10,'image_id'=>22,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>11,'complaint_id'=>2,'image_id'=>26,'type'=>'achievement','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>14,'complaint_id'=>11,'image_id'=>54,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>15,'complaint_id'=>12,'image_id'=>55,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>16,'complaint_id'=>13,'image_id'=>56,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>17,'complaint_id'=>14,'image_id'=>57,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>18,'complaint_id'=>15,'image_id'=>58,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>19,'complaint_id'=>16,'image_id'=>59,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            // ['id'=>26,'complaint_id'=>17,'image_id'=>60,'type'=>'complaint','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>21,'complaint_id'=>1,'image_id'=>61,'type'=>'achievement','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>22,'complaint_id'=>3,'image_id'=>62,'type'=>'achievement','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>23,'complaint_id'=>5,'image_id'=>63,'type'=>'achievement','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>24,'complaint_id'=>7,'image_id'=>64,'type'=>'achievement','created_at'=>NULL,'updated_at'=>NULL],
            ['id'=>25,'complaint_id'=>9,'image_id'=>64,'type'=>'achievement','created_at'=>NULL,'updated_at'=>NULL],





        ]);
    }
}
