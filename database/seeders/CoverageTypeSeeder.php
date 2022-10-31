<?php

namespace Database\Seeders;

use App\Models\CoverageType;
use App\Models\InsuranceCompany;
use Illuminate\Database\Seeder;

class CoverageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types_en = ['Comprehensive car insurance', 'Third Party Liability Insurance (Mandatory)'];
        $types_ar = ['التأمين الشامل على السيارات', 'تأمين مسؤولية الطرف الثالث (الإلزامي)'];


        for ($i = 0; $i < 2; $i++) {

            CoverageType::create([
                'name_en' => $types_en[$i],
                'name_ar' => $types_ar[$i],
            ]);
        }
    }
}
