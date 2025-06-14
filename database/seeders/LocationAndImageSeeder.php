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

            ['id' => 27, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749649959/secure_uploads/images/b46a2628-c160-489d-9e1f-f32b4218d7ea.jpg', 'created_at' => '2025-06-11 10:52:22', 'updated_at' => '2025-06-11 10:52:42'],
            ['id' => 28, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749650349/secure_uploads/images/bbbdcd48-592f-4734-97f1-7f2cfdb48179.jpg', 'created_at' => '2025-06-11 10:59:06', 'updated_at' => '2025-06-11 10:59:11'],
            ['id' => 29, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749650499/secure_uploads/images/5dfc4449-b9a3-4e02-87fe-07a0ad98d763.jpg', 'created_at' => '2025-06-11 11:01:36', 'updated_at' => '2025-06-11 11:01:42'],
            ['id' => 30, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749650605/secure_uploads/images/5e913101-aa9e-4c3f-b4dd-8e80b1cd49dd.jpg', 'created_at' => '2025-06-11 11:03:20', 'updated_at' => '2025-06-11 11:03:27'],
            ['id' => 31, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749651015/secure_uploads/images/0f9180ea-2873-46e5-b8db-239c46ce8b6c.jpg', 'created_at' => '2025-06-11 11:10:12', 'updated_at' => '2025-06-11 11:10:18'],
            ['id' => 32, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749651129/secure_uploads/images/51c15e24-5d27-48f8-9f89-0888c804c53d.jpg', 'created_at' => '2025-06-11 11:12:04', 'updated_at' => '2025-06-11 11:12:11'],
            ['id' => 33, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749651393/secure_uploads/images/1b5d3ac8-fda8-4a81-bb30-ead523127cca.jpg', 'created_at' => '2025-06-11 11:16:28', 'updated_at' => '2025-06-11 11:16:35'],
            ['id' => 34, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749651608/secure_uploads/images/4fd0634b-3ce3-4003-a6cc-615b5dc465f6.jpg', 'created_at' => '2025-06-11 11:20:04', 'updated_at' => '2025-06-11 11:20:10'],
            ['id' => 35, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749651899/secure_uploads/images/63546a85-ce62-43a8-affe-63c72175a8c7.jpg', 'created_at' => '2025-06-11 11:24:55', 'updated_at' => '2025-06-11 11:25:01'],
            ['id' => 36, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749652158/secure_uploads/images/4ff647d3-5115-49f6-8edf-811407592395.jpg', 'created_at' => '2025-06-11 11:29:17', 'updated_at' => '2025-06-11 11:29:21'],
            ['id' => 37, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749652819/secure_uploads/images/6432b7ed-b718-4150-82d2-aef9f21d88f8.jpg', 'created_at' => '2025-06-11 11:39:03', 'updated_at' => '2025-06-11 11:40:22'],
            ['id' => 38, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749652905/secure_uploads/images/1ff191d1-798c-43bd-bac6-70b2854101b0.jpg', 'created_at' => '2025-06-11 11:41:42', 'updated_at' => '2025-06-11 11:41:47'],
            ['id' => 39, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749653165/secure_uploads/images/6c68d7bf-9906-4eba-97c3-7ad69fe8b051.jpg', 'created_at' => '2025-06-11 11:46:02', 'updated_at' => '2025-06-11 11:46:07'],
            ['id' => 40, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749653403/secure_uploads/images/8bb8c1a6-59ed-4f13-a800-241f96a00597.jpg', 'created_at' => '2025-06-11 11:49:58', 'updated_at' => '2025-06-11 11:50:05'],
            ['id' => 41, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749653564/secure_uploads/images/fd37bea5-f47d-4228-8cab-3f3ede11819b.png', 'created_at' => '2025-06-11 11:52:39', 'updated_at' => '2025-06-11 11:52:46'],
            ['id' => 42, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749653722/secure_uploads/images/d878c192-3131-48c4-af4d-667424fe0cf5.jpg', 'created_at' => '2025-06-11 11:55:14', 'updated_at' => '2025-06-11 11:55:24'],
            ['id' => 43, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749653898/secure_uploads/images/81710012-4c06-43cb-bacd-4bcb4ee7e5c4.jpg', 'created_at' => '2025-06-11 11:58:16', 'updated_at' => '2025-06-11 11:58:20'],
            ['id' => 44, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749654070/secure_uploads/images/1c26ea57-203e-4f9f-a2a2-7d24f794de66.jpg', 'created_at' => '2025-06-11 12:01:08', 'updated_at' => '2025-06-11 12:01:13'],
            ['id' => 45, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749654260/secure_uploads/images/f082cb95-a0b9-4f13-bb46-c4d54ba3e3b6.jpg', 'created_at' => '2025-06-11 12:04:15', 'updated_at' => '2025-06-11 12:04:23'],
            ['id' => 46, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749654436/secure_uploads/images/c7ddc416-8a2f-4d02-b887-c82262df5bba.jpg', 'created_at' => '2025-06-11 12:07:14', 'updated_at' => '2025-06-11 12:07:18'],
            ['id' => 47, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749654599/secure_uploads/images/69dee193-92f1-4d4c-b4bf-0153a6fd7c78.jpg', 'created_at' => '2025-06-11 12:09:56', 'updated_at' => '2025-06-11 12:10:01'],
            ['id' => 48, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749654901/secure_uploads/images/2f619a8f-16db-4650-b0f6-d9feb96902aa.jpg', 'created_at' => '2025-06-11 12:14:57', 'updated_at' => '2025-06-11 12:15:04'],
            ['id' => 49, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749655045/secure_uploads/images/75919ae5-0fff-4eb0-88bf-9e66a20fbd83.jpg', 'created_at' => '2025-06-11 12:17:22', 'updated_at' => '2025-06-11 12:17:28'],
            ['id' => 50, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749655217/secure_uploads/images/afb495e5-5a95-40f6-bb95-b88a0105bd25.jpg', 'created_at' => '2025-06-11 12:20:13', 'updated_at' => '2025-06-11 12:20:19'],
            ['id' => 51, 'image_url' => 'https://res.cloudinary.com/df5wyvdtk/image/upload/v1749655532/secure_uploads/images/36642a4c-fd99-4f50-b9e5-07089867acd9.jpg', 'created_at' => '2025-06-11 12:25:24', 'updated_at' => '2025-06-11 12:25:35'],

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
                  ['id' => 12, 'longitude' => 36.2983286, 'latitude' => 33.4913481, 'name' => 'الميدان', 'created_at' => '2025-06-11 13:52:22', 'updated_at' => '2025-06-11 13:52:22'],
                  ['id' => 13, 'longitude' => 36.2466476, 'latitude' => 33.5026060, 'name' => 'المزة', 'created_at' => '2025-06-11 13:59:06', 'updated_at' => '2025-06-11 13:59:06'],
                  ['id' => 14, 'longitude' => 36.2766419, 'latitude' => 33.5229947, 'name' => 'المهاجرين', 'created_at' => '2025-06-11 14:01:36', 'updated_at' => '2025-06-11 14:01:36'],
                  ['id' => 15, 'longitude' => 36.2278245, 'latitude' => 33.5297490, 'name' => 'الشام الجديدة', 'created_at' => '2025-06-11 14:03:20', 'updated_at' => '2025-06-11 14:03:20'],
                  ['id' => 16, 'longitude' => 36.3362654, 'latitude' => 33.5465739, 'name' => 'القابون', 'created_at' => '2025-06-11 14:10:12', 'updated_at' => '2025-06-11 14:10:12'],
                  ['id' => 17, 'longitude' => 36.3118796, 'latitude' => 33.5572620, 'name' => 'القابون', 'created_at' => '2025-06-11 14:12:04', 'updated_at' => '2025-06-11 14:12:04'],
                  ['id' => 18, 'longitude' => 36.2932220, 'latitude' => 33.5029181, 'name' => 'الفحامة', 'created_at' => '2025-06-11 14:16:28', 'updated_at' => '2025-06-11 14:16:28'],
                  ['id' => 19, 'longitude' => 36.2685078, 'latitude' => 33.4843965, 'name' => 'كفرسوسة', 'created_at' => '2025-06-11 14:20:04', 'updated_at' => '2025-06-11 14:20:04'],
                  ['id' => 20, 'longitude' => 36.2332502, 'latitude' => 33.4938605, 'name' => 'فيلات غربية', 'created_at' => '2025-06-11 14:24:55', 'updated_at' => '2025-06-11 14:24:55'],
                  ['id' => 21, 'longitude' => 36.2983286, 'latitude' => 33.5399741, 'name' => 'ركن الدين', 'created_at' => '2025-06-11 14:29:17', 'updated_at' => '2025-06-11 14:29:17'],
                  ['id' => 22, 'longitude' => 36.2882776, 'latitude' => 33.5078014, 'name' => 'البرامكة', 'created_at' => '2025-06-11 14:39:03', 'updated_at' => '2025-06-11 14:39:03'],
                  ['id' => 23, 'longitude' => 36.2882776, 'latitude' => 33.5078014, 'name' => 'ساحة الأمويين', 'created_at' => '2025-06-11 14:41:42', 'updated_at' => '2025-06-11 14:41:42'],
                  ['id' => 24, 'longitude' => 33.5065379, 'latitude' => 36.2429856, 'name' => 'مزة جبل 86', 'created_at' => '2025-06-11 14:46:02', 'updated_at' => '2025-06-11 14:46:02'],
                  ['id' => 25, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'القدم', 'created_at' => '2025-06-11 14:49:58', 'updated_at' => '2025-06-11 14:49:58'],
                  ['id' => 26, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'الزاهرة', 'created_at' => '2025-06-11 14:52:39', 'updated_at' => '2025-06-11 14:52:39'],
                  ['id' => 27, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'دار الأيتام', 'created_at' => '2025-06-11 14:55:15', 'updated_at' => '2025-06-11 14:55:15'],
                  ['id' => 28, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'جامعة دمشق', 'created_at' => '2025-06-11 14:58:16', 'updated_at' => '2025-06-11 14:58:16'],
                  ['id' => 29, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'جوبر', 'created_at' => '2025-06-11 15:01:08', 'updated_at' => '2025-06-11 15:01:08'],
                  ['id' => 30, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'يلدا', 'created_at' => '2025-06-11 15:04:15', 'updated_at' => '2025-06-11 15:04:15'],
                  ['id' => 31, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'مشفى البيروني', 'created_at' => '2025-06-11 15:07:14', 'updated_at' => '2025-06-11 15:07:14'],
                  ['id' => 32, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'طريق المطار', 'created_at' => '2025-06-11 15:09:56', 'updated_at' => '2025-06-11 15:09:56'],
                  ['id' => 33, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'زملكا', 'created_at' => '2025-06-11 15:14:57', 'updated_at' => '2025-06-11 15:14:57'],
                  ['id' => 34, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'النيربين', 'created_at' => '2025-06-11 15:17:22', 'updated_at' => '2025-06-11 15:17:22'],
                  ['id' => 35, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'جوبر المدرسة', 'created_at' => '2025-06-11 15:20:13', 'updated_at' => '2025-06-11 15:20:13'],
                  ['id' => 36, 'longitude' => 36.2874860, 'latitude' => 33.4706897, 'name' => 'القابون المنازل', 'created_at' => '2025-06-11 15:25:24', 'updated_at' => '2025-06-11 15:25:24']
        ]);

    }
}
