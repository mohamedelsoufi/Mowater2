<?php

namespace Database\seeders;

use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\DeliveryMan;
use App\Models\DeliveryManCategory;
use App\Models\PaymentMethod;
use App\Models\Section;
use Illuminate\Database\Seeder;

class   DeliverySeeder extends Seeder
{

    public function run()
    {
        $brands = Brand::pluck('id')->toArray();
        $car_classes = CarClass::pluck('id')->toArray();
        $brand = $brands[array_rand($brands)];
        $car_model = CarModel::where('brand_id', $brand)->first();
        $vehicle_images = ['seeder/v1.jpg', 'seeder/sliders/second/9.jpg', 'seeder/v2.jpg', 'seeder/sliders/second/10.jpg', 'seeder/v3.jpg'];

        $name_en = ['Ahmed Salah', 'Mohamed Ahmed', 'Omnia Ahmed', 'Esraa Ahmed', 'Youssef Ahmed'];
        $name_ar = ['أحمد صلاح', 'محمد أحمد', 'أمنية أحمد', 'اسراء أحمد', 'يوسف أحمد'];
        $gender = ['male', 'male', 'female', 'female', 'male'];
        $description_en = ['Delivery Workers description', 'Student Delivery description', 'Goods Delivery description',
            'Delivery Request description', 'Delivery Outside Bahrain description'];
        $description_ar = ['توصيل عمال', 'توصيل طلاب', 'توصيل بضائع', 'توصيل خارج البحرين', 'طلب توصيل'];
        $vehicle_type = ['cars', 'motorcycles', 'cars', 'motorcycles', 'cars'];
        $manufacturing_year = ['2019', '2011', '2020', '2000', '2018'];
        $birth_date = ['1993-07-23', '1993-08-20', '1995-05-30', '1994-01-30', '1996-02-26'];
        $conveyor_type = ['automatic', 'manual', 'manual', 'manual', 'automatic'];
        $profile_picture = ['seeder/trainer.jpg', 'seeder/male1.jpg', 'seeder/female1.jpg', 'seeder/female2.jpg', 'seeder/male2.jpg'];
        $users = ['delivery_man_1@gmail.com', 'delivery_man_2@gmail.com', 'delivery_man_3@gmail.com', 'delivery_man_4@gmail.com', 'delivery_man_5@gmail.com'];

        $status = ['available', 'busy', 'not_available'];

        $section = Section::where('ref_name', 'DeliveryMan')->first()->id;
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];

        $cat_name_en = ['Delivery Workers', 'Student Delivery', 'Goods Delivery', 'Delivery Outside Bahrain', 'Delivery Request'];
        $cat_name_ar = ['توصيل عمال', 'توصيل طلاب', 'توصيل بضائع', 'توصيل خارج البحرين', 'طلب توصيل'];

        $is_negotiable = [0, 1];
        $price = [500, 1000, 1500, 2000, 2300];

        for ($c = 0; $c < 5; $c++) {
            $category = Category::create([
                'name_en' => $cat_name_en[$c],
                'name_ar' => $cat_name_ar[$c],
                'section_id' => $section
            ]);

        }
        for ($i = 0; $i < 5; $i++) {

            $delivery1 = DeliveryMan::create([
                'gender' => $gender[$i],
                'name_en' => $name_en[$i],
                'name_ar' => $name_ar[$i],
                'description_en' => $description_en[$i],
                'description_ar' => 'وصف ' . $description_ar[$i],
                'vehicle_type' => $vehicle_type[$i],
                'manufacturing_year' => $manufacturing_year[$i],
                'country_id' => '1',
                'city_id' => '1',
                'area_id' => '1',
                'car_model_id' => $car_model->id,
                'car_class_id' => $car_classes[array_rand($car_classes)],
                'brand_id' => $brand,
                'birth_date' => $birth_date[$i],
                'conveyor_type' => $conveyor_type[$i],
                'active' => 1,
                'available' => 1,
                'profile_picture' => $profile_picture[$i],
                'status' => $status[array_rand($status)]

            ]);

            $delivery1->file()->create([
                'path' => $vehicle_images[$i],
                'type' => 'vehicle_image',
            ]);
            $delivery1->file()->create([
                'path' => 'seeder/driving_license.jpg',
                'type' => 'driving_license',
            ]);
            $delivery1->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $delivery1->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $name_en[$i],
                'title_ar' => $name_ar[$i]
            ]);


            $payment_methods = PaymentMethod::pluck('id');
            $delivery1->payment_methods()->attach($payment_methods);

            $delivery1->organization_users()->create([
                'user_name' => 'delivery user' . $i,
                'email' => $users[$i],
                'password' => "123456",
            ]);

            $delivery1->work_time()->create([
                'from' => '09:00',
                'to' => '17:00',
                'duration' => '120',
                'days' => 'Sun,Sat,Mon,Tue,Wed,Thu',
            ]);

            $delivery1->discount_cards()->attach(1);

            $delivery_categories = category::where('section_id',$section)->pluck('id')->toArray();
            foreach ($delivery_categories as $category) {
                $delivery1->categories()->attach([$category]);
            }

            $delivery_man_categories = DeliveryManCategory::where('delivery_man_id', $delivery1->id)->get();
            foreach ($delivery_man_categories as $type) {
                $type->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 5,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 5 % على التالي',
                ]);
            }
        }


    }

}
