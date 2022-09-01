<?php

namespace Database\Seeders;

use App\Models\AdType;
use Illuminate\Database\Seeder;

class AdsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdType::create([
            'name_ar' => 'راعي',
            'name_en' => 'sponsor',
            'priority' => '4',
            'price' => '120'
        ]);
        AdType::create([
            'name_ar' => 'مميز',
            'name_en' => 'featured',
            'priority' => '3',
            'price' => '120'
        ]);
        AdType::create([
            'name_ar' => 'عادي',
            'name_en' => 'ordinal',
            'priority' => '2',
            'price' => '0'
        ]);
        AdType::create([
            'name_ar' => 'رابط',
            'name_en' => 'link',
            'priority' => '1',
            'price' => '0'
        ]);
    }
}
