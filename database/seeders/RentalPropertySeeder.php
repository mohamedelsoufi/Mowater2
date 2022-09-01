<?php

namespace Database\Seeders;

use App\Models\RentalProperty;
use Illuminate\Database\Seeder;

class RentalPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name_en = ['air conditioning','Monitor','vogue lamps','seat heating feature','sunroof'];
        $name_ar = ['تكييف','شاشة','مصابيح فوجات','خاصية تدفئة المقاعد','فتحة سقف'];
        $description_en = ['exist','none','exist','none','exist'];
        $description_ar = ['يوجد','لا يوجد','يوجد','لا يوجد','يوجد'];
        for ($p=0;$p<5;$p++){
            RentalProperty::create([
                'name_en' => $name_en[$p],
                'name_ar' => $name_ar[$p],
                'description_en' => $description_en[$p],
                'description_ar' => $description_ar[$p],
            ]);
        }
    }
}
