<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Section;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name_en' => 'Car Showrooms',
            'name_ar' => 'معارض سيارات',
            'section_id' => Section::where('ref_name', 'Agency')->first()->id
        ]);

        Category::create([
            'name_en' => 'Maintenance Centers',
            'name_ar' => 'مراكز صيانة',
            'section_id' => Section::where('ref_name', 'Agency')->first()->id
        ]);

        Category::create([
            'name_en' => 'spare parts',
            'name_ar' => 'قطع غيار',
            'section_id' => Section::where('ref_name', 'Agency')->first()->id
        ]);

        /***** */

        $garage_cat_en = ['German car garage', 'American car garage', 'plumbing', 'Air conditioner repair', 'mechanics', 'electrical',];
        $garage_cat_ar = ['كراج سيارات ألمانية', 'كراج سيارات أمريكية', 'سمكرة', 'تصليح مكيفات', 'ميكانيكيات', 'كهربائي',];
        for ($g = 0; $g < 6; $g++) {
            $cat = Category::create([
                'name_en' => $garage_cat_en[$g],
                'name_ar' => $garage_cat_ar[$g],
                'section_id' => Section::where('ref_name', 'Garage')->first()->id
            ]);

            for ($s = 0; $s < 2; $s++) {
                SubCategory::create([
                    'name_en' => $cat->name_en . ' ' . $s,
                    'name_ar' => $cat->name_ar . ' ' . $s,
                    'category_id' => $cat->id,
                ]);
            }

        }


        $number_of_digits = 0;


        $special_num_cat1 = Category::create([
            'name_en' => 'private car numbers',
            'name_ar' => 'أرقام السيارات الخصوصية',
            'section_id' => 4
        ]);

        $private_car_numbers_en = ['4 Numbers', '5 Numbers', '6 Numbers'];
        $private_car_numbers_ar = ['4 أرقام', '5 أرقام', '6 أرقام'];
        for ($p = 0; $p < 3; $p++) {

            if ($private_car_numbers_en[$p] == '4 Numbers') {
                $number_of_digits = 4;
            }

            if ($private_car_numbers_en[$p] == '5 Numbers') {
                $number_of_digits = 5;
            }

            if ($private_car_numbers_en[$p] == '6 Numbers') {
                $number_of_digits = 6;
            }
            SubCategory::create([
                'name_en' => $private_car_numbers_en[$p],
                'name_ar' => $private_car_numbers_ar[$p],
                'number_of_digits' => $number_of_digits,
                'category_id' => $special_num_cat1->id
            ]);
        }

        $special_num_cat2 = Category::create([
            'name_en' => 'motorcycle numbers',
            'name_ar' => 'أرقام الدراجات النارية',
            'section_id' => 4
        ]);

        $motorcycle_numbers_en = ['2 Numbers', '3 Numbers', '4 Numbers'];
        $motorcycle_numbers_ar = ['رقمين', '3 أرقام', '4 أرقام'];
        for ($p = 0; $p < 3; $p++) {
            if ($motorcycle_numbers_en[$p] == '2 Numbers') {
                $number_of_digits = 2;
            }

            if ($motorcycle_numbers_en[$p] == '3 Numbers') {
                $number_of_digits = 3;
            }

            if ($motorcycle_numbers_en[$p] == '4 Numbers') {
                $number_of_digits = 4;
            }
            SubCategory::create([
                'name_en' => $motorcycle_numbers_en[$p],
                'name_ar' => $motorcycle_numbers_ar[$p],
                'number_of_digits' => $number_of_digits,
                'category_id' => $special_num_cat2->id
            ]);
        }


        $special_num_cat3 = Category::create([
            'name_en' => 'shared car numbers',
            'name_ar' => 'سيارات عام مشترك (البيك أب)',
            'section_id' => 4
        ]);

        $shared_car_numbers_en = ['2 Numbers', '3 Numbers', '4 Numbers', '5 Numbers', '6 Numbers'];
        $shared_car_numbers_ar = ['رقمين', '3 أرقام', '4 أرقام', '5 أرقام', '6 أرقام'];
        for ($p = 0; $p < 5; $p++) {
            if ($shared_car_numbers_en[$p] == '2 Numbers') {
                $number_of_digits = 2;
            }

            if ($shared_car_numbers_en[$p] == '3 Numbers') {
                $number_of_digits = 3;
            }

            if ($shared_car_numbers_en[$p] == '4 Numbers') {
                $number_of_digits = 4;
            }

            if ($shared_car_numbers_en[$p] == '5 Numbers') {
                $array['number_of_digits'] = 5;
            }

            if ($shared_car_numbers_en[$p] == '6 Numbers') {
                $number_of_digits = 6;
            }
            SubCategory::create([
                'name_en' => $shared_car_numbers_en[$p],
                'name_ar' => $shared_car_numbers_ar[$p],
                'number_of_digits' => $number_of_digits,
                'category_id' => $special_num_cat3->id
            ]);
        }

        Category::create([
            'name_en' => 'Vehicles registration technical inspection centers',
            'name_ar' => 'مراكز الفحص الفني لتسجيل المركبات',
            'section_id' => 12
        ]);

        Category::create([
            'name_en' => 'Other technical inspection centers',
            'name_ar' => 'مراكز الفحص الفني الأخرى',
            'section_id' => 12
        ]);

        Category::create([
            'name_en' => 'Stationary washing centers',
            'name_ar' => 'مراكز غسيل ثابتة',
            'section_id' => 10
        ]);
        Category::create([
            'name_en' => 'Mobile washing centers',
            'name_ar' => 'مراكز غسيل متحركة',
            'section_id' => 10
        ]);
        Category::create([
            'name_en' => 'Care and polishing centers',
            'name_ar' => 'مراكز العناية والتلميع',
            'section_id' => 10
        ]);

        $types_en = ['Trucks', 'Heavy Equipment', 'Pickups', 'Cars', 'Motorcycles', 'Boats'];
        $types_ar = ['شاحنات', 'معدات ثقيلة', 'بيك أب', 'سيارات', 'دراجات نارية', 'قوارب'];
        for ($ac = 0; $ac < count($types_en); $ac++) {
            $cats = Category::create([
                'name_en' => $types_en[$ac],
                'name_ar' => $types_ar[$ac],
                'section_id' => 13
            ]);
            for ($sc = 0; $sc < 3; $sc++) {
                SubCategory::create([
                    'name_en' => $types_en[$ac] . $sc,
                    'name_ar' => $types_ar[$ac] . $sc,
                    'category_id' => $cats->id
                ]);
            }
        }
    }
}
