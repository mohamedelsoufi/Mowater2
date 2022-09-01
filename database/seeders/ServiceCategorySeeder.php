<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name_en'  => 'Transfer',
            'name_ar'  => 'نقل',
            'ref_name' => 'services'
        ]);

        Category::create([
            'name_en'  => 'Vehicle transportation',
            'name_ar'  => 'نقل مركبات',
            'ref_name' => 'services',
            'section_id' => 5
        ]);

        Category::create([
            'name_en'  => 'Troubleshooting',
            'name_ar'  => 'تصليح أعطال',
            'ref_name' => 'services',
            'section_id' => 5
        ]);

        Category::create([
            'name_en'  => 'Fuel supply',
            'name_ar'  => 'تزويد وقود',
            'ref_name' => 'services',
            'section_id' => 5
        ]);
    }
}
