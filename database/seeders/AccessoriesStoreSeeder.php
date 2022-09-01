<?php

namespace Database\Seeders;

use App\Models\AccessoriesStore;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\City;
use App\Models\PaymentMethod;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Faker\Factory;

class AccessoriesStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $name_ar = 'مركز الاكسسوار ';
        $name_en = 'Accessory Store ';
        $description_ar = 'تفاصيل مركز الاكسسوار ';
        $description_en = 'Details of Accessory Store ';
        $cities = City::all();
        $is_negotiable = [0, 1];
        $price = [1598753, 3578951, 258963, 147852, 147986325];
        $logos = ['accessoriesStore1.jpg', 'accessoriesStore2.jpg', 'accessoriesStore3.jpg',
            'accessoriesStore4.jpg', 'accessoriesStore5.jpg'];

        $images = ['accessory1.jpg', 'accessory2.jpg', 'accessory3.jpg', 'accessory4.jpg',
            'accessory5.jpg', 'accessory6.jpg', 'accessory7.jpg', 'accessory8.jpg', 'accessory9.jpg',
            'accessory10.jpg', 'accessory11.jpg', 'accessory12.jpg', 'accessory13.jpg', 'accessory14.jpg'];

//        $guarantee_month = ['01','02','03','04',''];
        foreach ($cities as $key => $city) {
            $store = AccessoriesStore::create([
                'logo' => 'seeder/' . $logos[$key],
                'name_en' => $name_en . $key,
                'name_ar' => $name_ar . $key,
                'description_en' => $description_en . $key,
                'description_ar' => $description_ar . $key,
                'tax_number' => mt_rand(15987, 35789),
                'city_id' => $city->id,
                'address' => '5 شارع اللملكة',
            ]);
            for ($t = 0; $t < 5; $t++) {
                $category = Category::where('section_id', 13)->inRandomOrder()->first()->id;
                $sub_category = SubCategory::where('category_id', $category)->inRandomOrder()->first()->id;
                $brand = Brand::inRandomOrder()->first()->id;
                $car_model = CarModel::where('brand_id', $brand)->inRandomOrder()->first()->id;
                $guarantee =$faker->numberBetween(0,1);
                $accessories = $store->accessories()->create([
                    'name_en' => 'Accessory name ' . $t,
                    'name_ar' => 'اسم الاكسسوار ' . $t,
                    'description_en' => 'Accessory description ' . $t,
                    'description_ar' => 'وصف الاكسسوار ' . $t,
                    'price' => mt_rand(550, 9526),
                    'category_id' => $category,
                    'sub_category_id' => $sub_category,
                    'brand_id' => $brand,
                    'car_model_id' => $car_model,
                    'guarantee' => $guarantee,
                    'guarantee_year' => $guarantee == 1 ? $faker->numberBetween(2022,2030) : '',
                    'guarantee_month' => $guarantee == 1 ? $faker->month : '',
                ]);
                for ($s = 0; $s < 5; $s++) {
                    $accessories->files()->create([
                        'path' => 'seeder/' . $images[array_rand($images)],
                        'type' => 'technical_inspection_center',
                    ]);
                }

            }
            $store->discount_cards()->attach(1);


            $store_accessories = $store->accessories;
            foreach ($store_accessories as $accessory) {
                $accessory->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 63,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 63 % على التالي',
                ]);
            }
            $store->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $store->payment_methods()->attach($payment_methods);

            $store->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $store->organization_users()->create([
                'user_name' => $name_en . ' ' . $key,
                'email' => 'accessories_store' . $key . '@gmail.com',
                'password' => "123456",
            ]);

        }
    }
}
