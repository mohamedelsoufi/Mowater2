<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name_en'  => 'exoskeleton',
            'name_ar'  => 'هياكل خارجية',
            'ref_name' => 'products'
        ]);

        Category::create([
            'name_en'  => 'motor',
            'name_ar'  => 'موتور',
            'ref_name' => 'products'
        ]);

        Category::create([
            'name_en'  => 'rims and tires',
            'name_ar'  => 'جنوط واطارات',
            'ref_name' => 'products'
        ]);

        Category::create([
            'name_en'  => 'cooling systems',
            'name_ar'  => 'انظمة التبريد',
            'ref_name' => 'products'
        ]);

        Category::create([
            'name_en'  => 'conditioning',
            'name_ar'  => 'التكييف',
            'ref_name' => 'products'
        ]);

        Category::create([
            'name_en'  => 'Mann Filters',
            'name_ar'  => 'فلاتر مان',
            'ref_name' => 'products'
        ]);

        Category::create([
            'name_en'  => 'brakes',
            'name_ar'  => 'الفرامل',
            'ref_name' => 'products'
        ]);

        Category::create([
            'name_en'  => 'the baggage',
            'name_ar'  => 'العفشة',
            'ref_name' => 'products'
        ]);


    }
}
