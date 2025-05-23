<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationAndImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('images')->insert([
            ['id' => 1,  'image_url' => 'http://just-fake-url', 'created_at' => '2025-05-21 15:22:05', 'updated_at' => '2025-05-21 15:22:05'],
            ['id' => 2,  'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747859746/secure_uploads/images/265a5fd7-e009-42fe-b41a-160fd41bc426.jpg', 'created_at' => '2025-05-21 15:30:29', 'updated_at' => '2025-05-21 17:35:47'],
            ['id' => 3,  'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747859748/secure_uploads/images/4359b0c3-d534-4fbe-8fd3-5a36ae040837.jpg', 'created_at' => '2025-05-21 15:37:09', 'updated_at' => '2025-05-21 17:35:48'],
            ['id' => 4,  'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747859749/secure_uploads/images/a9ecf1ff-f3be-4fab-ac28-525eb7fd9642.jpg', 'created_at' => '2025-05-21 17:15:36', 'updated_at' => '2025-05-21 17:35:49'],
            ['id' => 5,  'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747859751/secure_uploads/images/1345e459-b048-45c3-a967-92f4e77bd369.jpg', 'created_at' => '2025-05-21 17:22:57', 'updated_at' => '2025-05-21 17:35:51'],
            ['id' => 6,  'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747859752/secure_uploads/images/98ee6c98-1099-447f-a1ff-135d0bbbb614.jpg', 'created_at' => '2025-05-21 17:22:57', 'updated_at' => '2025-05-21 17:35:53'],
            ['id' => 8,  'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747860101/secure_uploads/images/f3d8aa68-780d-4ff9-82dc-89d858e56cb8.jpg', 'created_at' => '2025-05-21 17:41:39', 'updated_at' => '2025-05-21 17:41:42'],
            ['id' => 12, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747860864/secure_uploads/images/e02fea2c-695a-4484-ad1f-1f730136dde8.jpg', 'created_at' => '2025-05-21 17:54:20', 'updated_at' => '2025-05-21 17:54:24'],
            ['id' => 13, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747861031/secure_uploads/images/1dc7fde9-6a12-4ac2-8a33-e447f773ffbc.jpg', 'created_at' => '2025-05-21 17:57:09', 'updated_at' => '2025-05-21 17:57:11'],
            ['id' => 14, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747861080/secure_uploads/images/e4b642a5-65a7-4105-83db-babd0ecb845b.jpg', 'created_at' => '2025-05-21 17:57:58', 'updated_at' => '2025-05-21 17:58:01'],
            ['id' => 15, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747861094/secure_uploads/images/b8c874a1-3ff2-4d1b-a54a-ce224caf9cab.jpg', 'created_at' => '2025-05-21 17:58:11', 'updated_at' => '2025-05-21 17:58:14'],
            ['id' => 16, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747861104/secure_uploads/images/156add62-0170-436d-9b44-a4de61878668.jpg', 'created_at' => '2025-05-21 17:58:23', 'updated_at' => '2025-05-21 17:58:24'],
            ['id' => 17, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747861114/secure_uploads/images/a870cff5-a707-4b22-a5aa-a4571afc911a.jpg', 'created_at' => '2025-05-21 17:58:31', 'updated_at' => '2025-05-21 17:58:34'],
            ['id' => 18, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747861121/secure_uploads/images/dc0a4573-93e9-419e-9fbe-d7f9a06592d7.jpg', 'created_at' => '2025-05-21 17:58:39', 'updated_at' => '2025-05-21 17:58:42'],
            ['id' => 19, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747861129/secure_uploads/images/24e78d42-af9d-4c37-9f4a-0da68f60aa95.jpg', 'created_at' => '2025-05-21 17:58:46', 'updated_at' => '2025-05-21 17:58:49'],
            ['id' => 20, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747861139/secure_uploads/images/4256ea6a-0784-4a75-9b8a-51cf2d287a7a.jpg', 'created_at' => '2025-05-21 17:58:56', 'updated_at' => '2025-05-21 17:59:00'],
            ['id' => 21, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747861141/secure_uploads/images/9f4f4cbb-cdce-4aa3-8940-0b78b05baeed.jpg', 'created_at' => '2025-05-21 17:58:56', 'updated_at' => '2025-05-21 17:59:02'],
            ['id' => 22, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747861152/secure_uploads/images/76d1825f-6a18-421a-929a-cdf3e6fe202a.jpg', 'created_at' => '2025-05-21 17:59:09', 'updated_at' => '2025-05-21 17:59:12'],
            ['id' => 23, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747867187/secure_uploads/images/e3941bc5-cff8-4801-815e-38d3ae35e63c.jpg', 'created_at' => '2025-05-21 19:39:45', 'updated_at' => '2025-05-21 19:39:48'],
            ['id' => 24, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747867242/secure_uploads/images/4d7daed8-3b2d-4ee8-a887-35eddc60f6d6.jpg', 'created_at' => '2025-05-21 19:40:40', 'updated_at' => '2025-05-21 19:40:43'],
            ['id' => 25, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747867265/secure_uploads/images/c5decaa8-6f08-4e9a-ac43-dc2aa82039e4.jpg', 'created_at' => '2025-05-21 19:41:04', 'updated_at' => '2025-05-21 19:41:05'],
            ['id' => 26, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1747867588/secure_uploads/images/2bd17323-ecdb-4f57-800e-2eec35ae8c30.jpg', 'created_at' => '2025-05-21 19:46:26', 'updated_at' => '2025-05-21 19:46:30'],
        ]);


        DB::table('region')->insert([
            ['name' => 'دمشق', 'latitude' => 36.2768193, 'longitude' => 33.5132192, 'points' => 7],
            ['name' => 'كفرسوسة', 'latitude' => 36.2685078, 'longitude' => 33.4843965, 'points' => 5],
            ['name' => 'الشاغور', 'latitude' => 36.3118796, 'longitude' => 33.4891982, 'points' => 8],
            ['name' => 'الميدان', 'latitude' => 36.2983286, 'longitude' => 33.4913481, 'points' => 5],
            ['name' => 'المزة', 'latitude' => 36.246647569773, 'longitude' => 33.5026059754861, 'points' => 9],
            ['name' => 'حديقة الجاحظ', 'latitude' => 36.279977, 'longitude' => 33.5175767, 'points' => 7],
            ['name' => 'حديقة تشرين', 'latitude' => 36.2691857, 'longitude' => 33.5163949, 'points' => 2],
            ['name' => 'حديقة النيربين', 'latitude' => 36.2680842, 'longitude' => 33.5224665, 'points' => 4],
            ['name' => 'الشام الجديدة', 'latitude' => 36.2278245, 'longitude' => 33.529749, 'points' => 5],
            ['name' => 'الصالحية', 'latitude' => 36.287486, 'longitude' => 33.529055, 'points' => 9],
            ['name' => 'ركن الدين', 'latitude' => 36.2983286, 'longitude' => 33.5399741, 'points' => 3],
            ['name' => 'المهاجرين', 'latitude' => 36.2766419, 'longitude' => 33.5229947, 'points' => 5],
            ['name' => 'عين ترما', 'latitude' => 36.347101, 'longitude' => 33.5137422, 'points' => 4],
            ['name' => 'جوبر', 'latitude' => 36.330847, 'longitude' => 33.5192467, 'points' => 5],
            ['name' => 'زملكا', 'latitude' => 36.3525183, 'longitude' => 33.5264878, 'points' => 6],
            ['name' => 'برزة', 'latitude' => 36.3118796, 'longitude' => 33.557262, 'points' => 5],
            ['name' => 'القابون', 'latitude' => 36.3362654, 'longitude' => 33.5465739, 'points' => 10],
            ['name' => 'يلدا', 'latitude' => 36.3200091, 'longitude' => 33.4645624, 'points' => 8],
            ['name' => 'الحجر الأسود', 'latitude' => 36.3021834, 'longitude' => 33.4640191, 'points' => 6],
            ['name' => 'القدم', 'latitude' => 36.287486, 'longitude' => 33.4706897, 'points' => 6],
            ['name' => 'جرمانا', 'latitude' => 36.3561133, 'longitude' => 33.4809404, 'points' => 2],
            ['name' => 'المالكي', 'latitude' => 36.2714943, 'longitude' => 33.5173586, 'points' => 9],
            ['name' => 'المزرعة', 'latitude' => 36.2971713, 'longitude' => 33.5260848, 'points' => 3],
            ['name' => 'العدوي', 'latitude' => 36.3040104, 'longitude' => 33.523528, 'points' => 7],
            ['name' => 'أبو رمانة', 'latitude' => 36.2806827, 'longitude' => 33.5195179, 'points' => 4],
            ['name' => 'سوق الشعلان', 'latitude' => 36.2890086, 'longitude' => 33.5179872, 'points' => 9],
            ['name' => 'شارع الحمراء', 'latitude' => 36.2910414, 'longitude' => 33.5194434, 'points' => 7],
            ['name' => 'الحميدية', 'latitude' => 36.3051848, 'longitude' => 33.5114667, 'points' => 2],
            ['name' => 'باب توما', 'latitude' => 36.3150375, 'longitude' => 33.5113602, 'points' => 5],
            ['name' => 'باب مصلى', 'latitude' => 36.2959569, 'longitude' => 33.4979254, 'points' => 2],
            ['name' => 'باب سريجة', 'latitude' => 36.2969219, 'longitude' => 33.5058351, 'points' => 4],
            ['name' => 'باب شرقي', 'latitude' => 36.3179576, 'longitude' => 33.5094266, 'points' => 6],
            ['name' => 'الفحامة', 'latitude' => 36.293222, 'longitude' => 33.5029181, 'points' => 7],
            ['name' => 'البرامكة', 'latitude' => 36.2882776, 'longitude' => 33.5078014, 'points' => 4],
            ['name' => 'المجتهد', 'latitude' => 36.2970752, 'longitude' => 33.499929, 'points' => 3],
            ['name' => 'الزاهرة', 'latitude' => 36.3041256, 'longitude' => 33.4877726, 'points' => 5],
            ['name' => 'الزاهرة الجديدة', 'latitude' => 36.3023971, 'longitude' => 33.4863588, 'points' => 6],
            ['name' => 'مزة جبل 86', 'latitude' => 36.2429856, 'longitude' => 33.5065379, 'points' => 8],
            ['name' => 'الشيخ سعد', 'latitude' => 36.259017, 'longitude' => 33.5082766, 'points' => 7],
            ['name' => 'فيلات غربية', 'latitude' => 36.2332502, 'longitude' => 33.4938605, 'points' => 6],
            ['name' => 'فيلات شرقية', 'latitude' => 36.2389222, 'longitude' => 33.4893952, 'points' => 3],
            ['name' => 'أوتوستراد المزة', 'latitude' => 36.2432791, 'longitude' => 33.4940621, 'points' => 4],
            ['name' => 'القصاع', 'latitude' => 36.3166628, 'longitude' => 33.5177459, 'points' => 6],
            ['name' => 'القصور', 'latitude' => 36.3132346, 'longitude' => 33.5264234, 'points' => 5],
            ['name' => 'الجزيرة ١٦', 'latitude' => 36.2324745, 'longitude' => 33.5380311, 'points' => 7],
            ['name' => 'الجزيرة 10 ج', 'latitude' => 36.2179895, 'longitude' => 33.5218154, 'points' => 6],
            ['name' => 'البرج 1، الجزيرة 7', 'latitude' => 36.2273888, 'longitude' => 33.5283291, 'points' => 4],
            ['name' => 'الزاهرة', 'latitude' => 36.3041256, 'longitude' => 33.4877726, 'points' => 5],
            ['name' => 'الزاهرة الجديدة', 'latitude' => 36.3023971, 'longitude' => 33.4863588, 'points' => 4],
            ['name' => 'الشام الجديدة', 'latitude' => 36.2278245, 'longitude' => 33.529749, 'points' => 6],

        ]);

              DB::table('locations')->insert([
            ['id' => 1, 'latitude' => 33.5132192, 'longitude' => 36.2768193, 'name' => 'دمشق', 'created_at' => null, 'updated_at' => null],
            ['id' => 2, 'latitude' => 33.4843965, 'longitude' => 36.2685078, 'name' => 'كفرسوسة', 'created_at' => null, 'updated_at' => null],
            ['id' => 3, 'latitude' => 33.4891982, 'longitude' => 36.3118796, 'name' => ' الشاغور', 'created_at' => null, 'updated_at' => null],
            ['id' => 4, 'latitude' => 33.4913481, 'longitude' => 36.2983286, 'name' => 'الميدان', 'created_at' => null, 'updated_at' => null],
            ['id' => 5, 'latitude' => 33.5026060, 'longitude' => 36.2466476, 'name' => 'المزة', 'created_at' => null, 'updated_at' => null],
            ['id' => 6, 'latitude' => 33.5297490, 'longitude' => 36.2278245, 'name' => 'الشام الجديدة', 'created_at' => null, 'updated_at' => null],
            ['id' => 7, 'latitude' => 33.5290550, 'longitude' => 36.2874860, 'name' => 'الصالحية', 'created_at' => '2025-05-21 15:30:29', 'updated_at' => '2025-05-21 15:30:29'],
            ['id' => 8, 'latitude' => 33.5399741, 'longitude' => 36.2983286, 'name' => 'ركن الدين', 'created_at' => '2025-05-21 15:37:09', 'updated_at' => '2025-05-21 15:37:09'],
            ['id' => 9, 'latitude' => 33.5082766, 'longitude' => 36.2590170, 'name' => 'الشيخ سعد', 'created_at' => '2025-05-21 17:15:36', 'updated_at' => '2025-05-21 17:15:36'],
            ['id' => 10, 'latitude' => 33.5179872, 'longitude' => 36.2890086, 'name' => 'سوق الشعلان', 'created_at' => '2025-05-21 17:22:57', 'updated_at' => '2025-05-21 17:22:57'],
            ['id' => 11, 'latitude' => 33.4809404, 'longitude' => 36.3561133, 'name' => 'جرمانا', 'created_at' => '2025-05-21 17:31:52', 'updated_at' => '2025-05-21 17:31:52'],
        ]);

    }
}
