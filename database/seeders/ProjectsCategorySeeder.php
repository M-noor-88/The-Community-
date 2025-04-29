<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class ProjectsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'إنارة الشوارع بالطاقة الشمسية',
            'تنظيف وتزيين الأماكن العامة',
            'يوم خيري',
            'حملات تشجير',
            'ترميم أضرار (كوارث , عدوان)'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
