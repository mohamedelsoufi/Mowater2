<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\Scrap;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class ScrapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logos = ['m7.png', 'm8.png', 'm9.jpg', 'm10.jpg', 'm11.jpg', 'm12.jpg'];
        $users = ['scrap1@gmail.com', 'scrap2@gmail.com', 'scrap3@gmail.com', 'scrap4@gmail.com', 'scrap5@gmail.com', 'scrap6@gmail.com'];
        $type = ['commercial', 'original'];
        $status = ['good', 'very_good', 'excellent'];
        $price = [1598753, 3578951, 258963, 147852, 147986325];
        $manufacturing_year = ['2020', '2021', '2022'];
        $car_class = [1, 2, 3];
        $is_new = [0, 1];

        for ($counter = 0; $counter < 6; $counter++) {
            $scrap = Scrap::create([
                'name_en' => 'scrap' . $counter,
                'name_ar' => 'سكراب' . $counter,
                'description_en' => 'description scrap 1' . $counter,
                'description_ar' => 'وصف سكراب 1' . $counter,
                'logo' => 'seeder/' . $logos[$counter],
                'active' => 1,
                'available' => 1,
                'reservation_availability' => 1,
                'delivery_availability' => 1,
                'reservation_active' => 1,
                'delivery_active' => 1,
                'country_id' => Country::where('name_en', 'Bahrain')->first()->id,
                'city_id' => City::first()->id,
                'area_id' => Area::where('city_id', City::first()->id)->first()->id,
                'year_founded' => '1990',
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $scrap->payment_methods()->attach($payment_methods);

            $scrap->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $scrap->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $scrap->organization_users()->create([
                'user_name' => 'Scarp' . $counter,
                'email' => $users[$counter],
                'password' => "123456",
            ]);

            $categories = Category::where('section_id', null)->where('ref_name','products')->get();

            foreach ($categories as $key => $category) {
                $brands = Brand::all();
                foreach ($brands as $brand) {
                    $car_models = CarModel::where('brand_id', $brand->id)->get();
                    foreach ($car_models as $car_model) {
                        $products = $scrap->products()->create([
                            'name_en' => 'scrap' . ' ' . $brand->name_en,
                            'name_ar' => $brand->name_ar . ' ' . 'سكراب',
                            'description_en' => 'scrap' . ' ' . $brand->name_en . ', ' . $car_model->name_en,
                            'description_ar' => $brand->name_ar . ', ' . $car_model->name_ar . ' ' . 'سكراب',
                            'brand_id' => $car_model->brand_id,
                            'car_model_id' => $car_model->id,
                            'car_class_id' => $car_class[array_rand($car_class)],
                            'manufacturing_year' => $manufacturing_year[array_rand($manufacturing_year)],
                            'price' => $price[array_rand($price)],
                            'type' => $type[array_rand($type)],
                            'status' => $status[array_rand($status)],
                            'category_id' => $category->id,
                            'sub_category_id' => SubCategory::where('category_id', $category->id)->first()->id,
                        ]);
                        $products->files()->create([
                            'path' => 'seeder/scrap_cars.jpg',
                            'type' => 'image'
                        ]);
                    }
                }

            }


        }
    }
}

