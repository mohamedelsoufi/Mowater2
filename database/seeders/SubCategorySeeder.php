<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::where('section_id', null)->get();
        foreach ($categories as $category) {
            for ($i = 0; $i < 5; $i++) {
                SubCategory::create([
                    'name_en' => $category->name_en . $i,
                    'name_ar' => $category->name_ar . $i,
                    'category_id' => $category->id,
                ]);
            }
        }
        $vehicle_transportation_en = ['Small Vehicle Transport', 'Truck transport', 'Four-wheel drive transport',
            'Motorcycle transport', 'Boat transport', 'Luxury vehicle transport','Sports car transport', 'Accident Vehicle Transport', 'Scrap transport'];
        $vehicle_transportation_ar = ['نقل مركبات صغيرة', 'نقل شاحنات', 'نقل مركبات دفع رباعي', 'نقل دراجات نارية', 'نقل قوارب', 'نقل سيارات فخمة','نقل سيارات رياضية', 'نقل مركبات حوادث', 'نقل سكراب'];

        $troubleshooting_en = ['Changing Tires', 'Charge batteries', 'Unlock closed vehicle'];
        $troubleshooting_ar = ['تغيير إطارات', 'شحن بطاريات', 'فتح مركبة مغلقة'];

        $fuel_supply_en = ['Diesel', 'Good', 'Excellent', 'Super'];
        $fuel_supply_ar = ['ديزل', 'جيد', 'ممتاز', 'سوبر'];

        $vehicle_transportation_cat = Category::where('ref_name','services')->where('section_id',5)
            ->where('name_en','Vehicle transportation')->first();

        $troubleshooting_cat = Category::where('ref_name','services')->where('section_id',5)
            ->where('name_en','Troubleshooting')->first();

        $fuel_supply_cat = Category::where('ref_name','services')->where('section_id',5)
            ->where('name_en','Fuel supply')->first();

        for ($w = 0; $w < 8; $w++) {
            SubCategory::create([
                'name_en' => $vehicle_transportation_en[$w],
                'name_ar' => $vehicle_transportation_ar[$w],
                'category_id' => $vehicle_transportation_cat->id,
            ]);
        }

        for ($e = 0; $e < 3; $e++) {
            SubCategory::create([
                'name_en' => $troubleshooting_en[$e],
                'name_ar' => $troubleshooting_ar[$e],
                'category_id' => $troubleshooting_cat->id,
            ]);
        }

        for ($n = 0; $n < 4; $n++) {
            SubCategory::create([
                'name_en' => $fuel_supply_en[$n],
                'name_ar' => $fuel_supply_ar[$n],
                'category_id' => $fuel_supply_cat->id,
            ]);
        }

    }
}
