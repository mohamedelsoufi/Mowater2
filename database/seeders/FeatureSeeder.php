<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\InsuranceCompany;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feature_en = ['Agency repair','Agency repair','Roadside assistance','New car replacement','Fire and theft coverage',
            'Windshield cover','Personal accident coverage for driver and passenger','Off-road coverage','Personal baggage coverage',
            'Natural disaster coverage','Dent repair','Replacing the locks'];
        $feature_ar = ['تصليح لدى الوكالة','النقات الطبية الطارئة','المساعدة على الطريق','استبدال سيارة جديدة','تغطية الحريق والسرقة','تغطية الزجاج الأمامي','تغطية الحوادث الشخصية للسائق والراكب',
            'تغطية الطرق الوعرة','تغطية الأمتعة الشخصية','تغطية الكوارث الطبيعية','إصلاح دنت','استبدال الأقفال'];

            for ($i = 0; $i < 12; $i++) {
                $feature =  Feature::create([
                    'name_en' => $feature_en[$i],
                    'name_ar' => $feature_ar[$i],
                ]);

        }
    }
}
