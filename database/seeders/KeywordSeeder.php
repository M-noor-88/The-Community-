<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keyword;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keywords = [
            ['word' => 'خطر', 'points' => 5],
            ['word' => 'مخالفة', 'points' => 7],
            ['word' => 'كهرباء', 'points' => 4],
            ['word' => 'إنارة', 'points' => 6],
            ['word' => 'مياه', 'points' => 3],
            ['word' => 'صرف', 'points' => 8],
            ['word' => 'صحي', 'points' => 6],
            ['word' => 'تسرب', 'points' => 4],
            ['word' => 'تسليك', 'points' => 5],
            ['word' => 'حفرة', 'points' => 7],
            ['word' => 'انهيار', 'points' => 9],
            ['word' => 'تشقق', 'points' => 6],
            ['word' => 'تصدع', 'points' => 8],
            ['word' => 'متصدع', 'points' => 5],
            ['word' => 'آيل', 'points' => 7],
            ['word' => 'تهديد', 'points' => 6],
            ['word' => 'مزعج', 'points' => 4],
            ['word' => 'إزعاج', 'points' => 5],
            ['word' => 'ضوضاء', 'points' => 3],
            ['word' => 'روائح', 'points' => 6],
            ['word' => 'كريهة', 'points' => 5],
            ['word' => 'نفايات', 'points' => 4],
            ['word' => 'قمامة', 'points' => 5],
            ['word' => 'تراكم', 'points' => 7],
            ['word' => 'ازدحام', 'points' => 6],
            ['word' => 'عرقلة', 'points' => 5],
            ['word' => 'مرور', 'points' => 4],
            ['word' => 'أرصفة', 'points' => 6],
            ['word' => 'أشغال', 'points' => 7],
            ['word' => 'بناء', 'points' => 8],
            ['word' => 'ترميم', 'points' => 4],
            ['word' => 'قديم', 'points' => 3],
            ['word' => 'متآكل', 'points' => 6],
            ['word' => 'متضرر', 'points' => 5],
            ['word' => 'مظلم', 'points' => 4],
            ['word' => 'معتم', 'points' => 3],
            ['word' => 'شوارع', 'points' => 6],
            ['word' => 'نظافة', 'points' => 5],
            ['word' => 'تلوث', 'points' => 4],
            ['word' => 'حريق', 'points' => 9],
            ['word' => 'شرارة', 'points' => 6],
            ['word' => 'كهربائي', 'points' => 7],
            ['word' => 'كابل', 'points' => 5],
            ['word' => 'مكشوف', 'points' => 6],
            ['word' => 'سقوط', 'points' => 8],
            ['word' => 'سيول', 'points' => 7],
            ['word' => 'فيضان', 'points' => 7],
            ['word' => 'انسداد', 'points' => 5],
            ['word' => 'رائحة', 'points' => 3],
            ['word' => 'ممر', 'points' => 4],
            ['word' => 'حاوية', 'points' => 6],
            ['word' => 'غير موجودة', 'points' => 4],
            ['word' => 'قديمة', 'points' => 5],
            ['word' => 'تالفة', 'points' => 6],
            ['word' => 'فوضى', 'points' => 5],
            ['word' => 'أعمدة', 'points' => 4],
            ['word' => 'مكسورة', 'points' => 5],
            ['word' => 'أسلاك', 'points' => 7],
            ['word' => 'متشابكة', 'points' => 6],
            ['word' => 'ارتفاع', 'points' => 3],
            ['word' => 'صوت', 'points' => 2],
            ['word' => 'ضجيج', 'points' => 3],
            ['word' => 'ضغط', 'points' => 4],
            ['word' => 'شبكة', 'points' => 6],
            ['word' => 'فحص', 'points' => 5],
            ['word' => 'تدخل', 'points' => 4],
            ['word' => 'صيانة', 'points' => 5],
            ['word' => 'طوارئ', 'points' => 8],
            ['word' => 'تأخير', 'points' => 3],
            ['word' => 'عطل', 'points' => 5],
            ['word' => 'مشكلة', 'points' => 4],
            ['word' => 'فني', 'points' => 3],
            ['word' => 'مقطوعة', 'points' => 6],
            ['word' => 'انقطاع', 'points' => 7],
            ['word' => 'مزاريب', 'points' => 3],
            ['word' => 'مهترئة', 'points' => 4],
            ['word' => 'أوساخ', 'points' => 3],
            ['word' => 'إعاقة', 'points' => 5],
            ['word' => 'طريق', 'points' => 4],
            ['word' => 'زحمة', 'points' => 6],
            ['word' => 'انزلاق', 'points' => 5],
            ['word' => 'خلل', 'points' => 4],
            ['word' => 'ترخيص', 'points' => 7],
            ['word' => 'غير مرخص', 'points' => 6],
            ['word' => 'تجاوز', 'points' => 4],
            ['word' => 'سكني', 'points' => 3],
            ['word' => 'قانونية', 'points' => 2],
            ['word' => 'إشغال', 'points' => 5],
            ['word' => 'تعدي', 'points' => 6],
            ['word' => 'مبنى', 'points' => 7],
            ['word' => 'مهدد', 'points' => 8],
            ['word' => 'غير آمن', 'points' => 7],
            ['word' => 'تهالك', 'points' => 5],
            ['word' => 'هبوط', 'points' => 6],
            ['word' => 'غمر', 'points' => 4],
            ['word' => 'إغلاق', 'points' => 5],
            ['word' => 'إعادة', 'points' => 3],
            ['word' => 'فتح', 'points' => 2],
            ['word' => 'تشويه', 'points' => 3],
            ['word' => 'منظر عام', 'points' => 4],

            // Add more keywords as needed
        ];

        foreach ($keywords as $item) {
            Keyword::create($item);
        }
    }
}
