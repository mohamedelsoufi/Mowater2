<?php

namespace Database\Seeders;

use App\Models\DiscountCard;
use Illuminate\Database\Seeder;

class DiscountCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DiscountCard::create([
            'title_en'=>'Mawater Card 2022',
            'title_ar' => 'بطاقة مواتر 2022',
            'price' => 158632,
            'year' => '2022',
            'image'=>'seeder/dc.png',
            'status' => 'started',
            'active'=>1
        ]);
    }
}
