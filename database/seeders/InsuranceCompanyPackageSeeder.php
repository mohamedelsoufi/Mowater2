<?php

namespace Database\Seeders;

use App\Models\CoverageType;
use App\Models\Feature;
use App\Models\InsuranceCompany;
use Illuminate\Database\Seeder;

class InsuranceCompanyPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = InsuranceCompany::get();
        $coverage = CoverageType::pluck('id')->toArray();
        $features = Feature::inRandomOrder()->take(7)->pluck('id');
        $is_negotiable = [0, 1];
        $price = [1598753, 3578951, 258963, 147852, 147986325];
        $name_en = ['golden package', 'silver package', 'bronze package'];
        $name_ar = ['الباقة الذهبية', 'الباقة الفضية', 'الباقة البرونزية'];

        foreach ($companies as $company) {
            for ($c = 0; $c < count($name_en); $c++) {
                $package = $company->packages()->create([
                    'name_en' => $name_en[$c],
                    'name_ar' => $name_ar[$c],
                    'price' => 880,
                    'coverage_type_id' => $coverage[array_rand($coverage)]
                ]);
                $package->features()->attach($features);

                    $package->offers()->create([
                        'discount_card_id' => 1,
                        'discount_type' => 'percentage',
                        'discount_value' => 77,
                        'number_of_uses_times' => 'specific_number',
                        'specific_number' => 2,
                        'notes' => 'خصم 77 % على التالي',
                    ]);

            }

        }
    }
}
