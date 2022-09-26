<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\Agency;
use App\Models\Brand;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;
use App\Models\Color;
use App\Models\CarModel;
use App\Models\CarClass;


class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = Brand::get();
        $logos = ['toyota-Logo.jpg', 'ford-logo.png', 'honda-logo.jpg', 'kia-logo.png', 'merceedes-logo.jpg', 'bmw-logo.png']; //'seeder/toyota-Logo.jpg'
        $users = ['toyota_user@gmail.com', 'ford_user@gmail.com', 'honda_user@gmail.com', 'kia_user@gmail.com', 'merceedes_user@gmail.com', 'bmw_user@gmail.com'];
        $branch_users = ['ba1@gmail.com', 'ba2@gmail.com', 'ba3@gmail.com', 'ba4@gmail.com'];

        $vehicle_images = [];
        for ($i = 1; $i <= 30; $i++) {
            array_push($vehicle_images, "seeder/v$i.jpg");
        }
        $manufacturing_year = ['2020', '2021', '2022'];
        $is_new = [0, 1];
        $traveled_distance = [25000, 30000, 100000, 150000, 200000];
        $traveled_distance_type = ['km', 'mile'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $year = ['2021', '2022', '2023', '2024', '2025'];
        $color = [1, 2];
        $doors_number = [4, 2];
        $price = [1598753, 3578951, 258963, 147852, 147986325];
        $threeD = ['seeder/1.glb', 'seeder/2.glb'];
        $payment_methods = PaymentMethod::pluck('id');
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];

        foreach ($brands as $main_key => $brand) {
            $agency1 = Agency::create([
                'name_en' => $brand->name_en . ' Agency',
                'name_ar' => 'وكالة ' . $brand->name_ar,
                'description_en' => $brand->name_en . ' Bahrain is proud to be part of the Kingdom’s journey of transformation for over 50 years.',
                'description_ar' => "تفتخر {$brand->name_ar} البحرين بكونها جزء من رحلة التطوير في المملكة على مدى 50 عاماً.",
                'brand_id' => $brand->id,
                'tax_number' => mt_rand(123456, 987654),
                'logo' => array_key_exists($main_key, $logos) ? "seeder/" . $logos[$main_key] : '',
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

            $agency1->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);


            $agency1->payment_methods()->attach($payment_methods);

            $agency1->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $agency1->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => 'name ' . $main_key,
                'title_ar' => 'الاسم ' . $main_key
            ]);

            $car_models = CarModel::where('brand_id', $brand->id)->get();
            $car_classes = CarClass::get();

            $agency1->discount_cards()->attach(1);

            foreach ($car_models as $key => $car_model) {
                foreach ($car_classes as $car_class) {
                    $vehicle_type = ['cars', 'trucks', 'pickups'];
                    $ghamara_count = '';
                    if ($vehicle_type[array_rand($vehicle_type)] == 'pickups') {
                        $ghamara_count = array_rand(ghamara_count_arr());
                    }
                    $vehicle = $agency1->vehicles()->create([
                        'vehicle_type' => $vehicle_type[array_rand($vehicle_type)],
//                        'ghamara_count' => $ghamara_count,
                        'brand_id' => $brand->id,
                        'car_model_id' => $car_model->id,
                        'car_class_id' => $car_class->id,
                        'manufacturing_year' => $manufacturing_year[array_rand($manufacturing_year)],
                        'is_new' => 1,
//                        'traveled_distance' => $traveled_distance[array_rand($traveled_distance)],
//                        'traveled_distance_type' => $traveled_distance_type[array_rand($traveled_distance_type)],
                        'outside_color_id' => 1,
                        'inside_color_id' => 2,
                        'in_bahrain' => array_rand($is_new),
                        'country_id' => Country::first()->id,
                        'guarantee' => array_rand($is_new),
                        'guarantee_month' => $month[array_rand($month)],
                        'guarantee_year' => $year[array_rand($year)],
                        'transmission_type' => array_rand(transmission_type_arr()),
                        'engine_size' => array_rand(engine_size_arr()),
                        'start_with_fingerprint' => array_rand($is_new),
                        'cylinder_number' => array_rand(cylinder_number_arr()),
                        'fuel_type' => array_rand(fuel_type_arr()),
                        'wheel_drive_system' => array_rand(wheel_drive_system_arr()),
                        'specifications' => array_rand(specifications_arr()),
//                        'status' => array_rand(status_arr()),
                        'insurance' => array_rand($is_new),
                        'insurance_month' => $month[array_rand($month)],
                        'insurance_year' => $year[array_rand($year)],
                        'coverage_type' => array_rand(coverage_type_arr()),
                        'remote_start' => array_rand($is_new),
                        'screen' => array_rand($is_new),
                        'seat_upholstery' => array_rand(seat_upholstery_arr()),
                        'air_conditioning_system' => array_rand(air_conditioning_system_arr()),
                        'windows_control' => array_rand(windows_control_arr()),
                        'electric_back_door' => array_rand($is_new),
                        'wheel_size' => array_rand(wheel_size_arr()),
                        'wheel_type' => array_rand(wheel_type_arr()),
                        'sunroof' => array_rand(sunroof_arr()),
                        'doors_number' => $doors_number[array_rand($doors_number)],
                        'start_engine_with_button' => array_rand($is_new),
                        'seat_adjustment' => array_rand($is_new),
                        'seat_heating_cooling_function' => array_rand($is_new),
                        'seat_massage_feature' => array_rand($is_new),
                        'seat_memory_feature' => array_rand($is_new),
                        'fog_lights' => array_rand($is_new),
                        'front_lighting' => array_rand(front_lighting_arr()),
                        'selling_by_plate' => array_rand($is_new),
                        'number_plate' => '',
                        'price_is_negotiable' => array_rand($is_new),
                        'location' => '',
                        'additional_notes' => '',
                        'price' => $price[array_rand($price)],
                        'availability' => array_rand($is_new),
                        'active' => array_rand($is_new),
                    ]);

                    for ($i = 0; $i < 4; $i++) {
                        $vehicle->files()->create([
                            'path' => $vehicle_images[array_rand($vehicle_images)],
                            'type' => 'vehicle_image',
                            'color_id' => $i <= 1 ? Color::first()->id : Color::skip(1)->first()->id,
                        ]);
                    }
                    $vehicle->files()->create([
                        'path' => $threeD[array_rand($threeD)],
                        'type' => 'vehicle_3D',
                        'color_id' => 1,
                    ]);

                    $vehicle->offers()->create([
                        'discount_card_id' => 1,
                        'discount_type' => 'percentage',
                        'discount_value' => 5,
                        'number_of_uses_times' => 'specific_number',
                        'specific_number' => 2,
                        'notes' => 'خصم 5 % على التالي',
                    ]);

                    $name_en = ['Car mirror sticker waterproof and anti-fog', 'spare parts set belt', 'Complete dynamo spool - OEM 252812b010', 'R Brake Front Brake Pads ( VW GROUP ) RB2111'];
                    $name_ar = ['لازق مرايا مضاده للماء و الضباب للسياره', 'سير مجموعة', 'بكرة دينامو كاملة - OEM 252812b010', 'طقم تيل فرامل امامى R Brake ( VW GROUP) RB2111 '];
                    $description_en = ['Car mirror sticker waterproof and anti-fog', 'spare parts set belt', 'Complete dynamo spool - OEM 252812b010', 'R Brake Front Brake Pads ( VW GROUP ) RB2111'];
                    $description_ar = ['لازق مرايا مضاده للماء و الضباب للسياره', 'سير مجموعة', 'بكرة دينامو كاملة - OEM 252812b010', 'طقم تيل فرامل امامى R Brake ( VW GROUP) RB2111 '];
                    $images = ['p1.jpg', 'p2.jpg', 'p3.jpg', 'p4.jpg', 'p5.jpg', 'p6.jpg', 'p7.jpg', 'p8.jpg', 'p9.jpg', 'p10.jpg',];

                    $categories = Category::where('section_id', 1)->where('id', 3)->inRandomOrder()->get();

                    foreach ($categories as $category) {
                        $agency1->categories()->attach($category->id);
                        for ($i = 0; $i < 3; $i++) {
                            $p = $agency1->products()->create([
                                'name_en' => $name_en[$i] . ' ' . $car_model->name_en,
                                'name_ar' => $name_ar[$i] . ' ' . $car_model->name_ar,
                                'description_en' => $description_en[$i] . ' ' . $car_model->description_en,
                                'description_ar' => $description_ar[$i] . ' ' . $car_model->description_ar,
                                'brand_id' => $brand->id,
                                'car_model_id' => $car_model->id,
                                'car_class_id' => $car_class->id,
                                'manufacturing_year' => $manufacturing_year[array_rand($manufacturing_year)],
                                'engine_size' => array_rand(engine_size_arr()),
                                'price' => $i * 6,
                                'status' => 'excellent',
                                'type' => 'original',
                                'is_new' => 1,
                                'category_id' => $category->id,
                                'warranty_value' => $i > 3 ? null : '3 months',
                            ]);


                            $p->files()->create([
                                'path' => 'seeder/' . $images[array_rand($images)],
                            ]);

                            $p->files()->create([
                                'path' => 'seeder/' . $images[array_rand($images)],
                            ]);

                            $p->offers()->create([
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

            $org_user = $agency1->organization_users()->create([
                'user_name' => $brand->name,
                'email' => $users[$main_key],
                'password' => "123456",
            ]);

            $org_role = $agency1->roles()->create([
                'name_en' => 'Organization super admin' .' '. $agency1->name_en,
                'name_ar' => 'صلاحية المدير المتميز' .' '. $agency1->name_ar,
                'display_name_ar' => 'صلاحية المدير المتميز' .' '. $agency1->name_ar,
                'display_name_en' => 'Organization super admin' .' '. $agency1->name_en,
                'description_ar' => 'له جميع الصلاحيات',
                'description_en' => 'has all permissions',
                'is_super' => 1,
            ]);

            foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
                foreach ($values as $value) {
                    $permission = Permission::create([
                        'name' => $value . '-' . $key.'-'. $agency1->name_en,
                        'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $agency1->name_ar,
                        'display_name_en' => $value . ' ' . $key . ' ' . $agency1->name_en,
                        'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $agency1->name_ar,
                        'description_en' => $value . ' ' . $key . ' ' . $agency1->name_en,
                    ]);
                    $org_role->attachPermissions([$permission]);
                }
            }

            $org_user->attachRole($org_role);


            $service_name_en = ['car transport', 'Change and charge a battery', 'Post a frame and change frames',
                'Changing the oil of all kinds of vehicles', 'additional services',];
            $service_name_ar = ['نقل سيارة', 'تغيير وشحن بطارية', 'بنشر إطار وتغيير إطارات', 'تغيير زيت المركبات بأنواعها', 'خدمات إضافية',];
            $service_desc_en = ['car transport', 'Change and charge a battery', 'Post a frame and change frames',
                'Changing the oil of all kinds of vehicles', 'additional services',];
            $service_desc_ar = ['ينما كنت نحن معك وبخطوات بسيطة وبأقل من دقيقة تسطيع طلب نقل سيارتك بواسطة الونش من وإلى اي جهة تختارها',
                'كل ما عليك فعلة اختيار أيقونة خدمات البطاريات وكتابة نوع سيارتك وتاريخ صنعها وسوف نقوم بتغير بطارية جديدة لك بالموقع الذي قمت بتحديده مسبقاً',
                'كم مرة خرجت من المنزل ووجدت إطار السيارة يحتاج لتغير والطقس حار أو بارد أو ستتأخر على عملك، ما عليك نحن معاك، اطلب خدمة تغير الإطار من خلال تطبيق معاك وسوف نقوم بخدمتك.',
                'نعم تستطيع الآن وانت في منزلك أو مكان عملك تغيير زيت المحرك والفلاتر اللازمة فقط كل ما عليك هو تحديد موقعك', 'كل ما يتعلق بصيانة السيارات والعناية الخاصة يمكنك الاستفادة من هذه الأيقونة من عدة خدمات مثل الصيانة السريعة'];
            $service_price = [25000, 60, 40, 65, 255];

            $service_category = Category::where('ref_name', 'services')->first();
            for ($s = 0; $s < 5; $s++) {
                $service_offer = $agency1->services()->create([
                    'name_en' => $service_name_en[$s],
                    'name_ar' => $service_name_ar[$s],
                    'description_en' => $service_desc_en[$s],
                    'description_ar' => $service_desc_ar[$s],
                    'price' => $service_price[$s],
                    'category_id' => $service_category->id,
                    'location_required' => true,
                ]);
            }

            $service_offer->offers()->create([
                'discount_card_id' => 1,
                'discount_type' => 'amount',
                'discount_value' => 200,
                'number_of_uses_times' => 'endless',
                'notes' => 'خصم 200 درهم على الخدمة',
            ]);


            $vehicles = $agency1->vehicles()->pluck('id');
            $products = $agency1->products()->pluck('id');

            for ($b = 0; $b < 4; $b++) {
                $branch = $agency1->branches()->create([
                    'name_en' => 'Branch ' . $b,
                    'name_ar' => 'فرع ' . $b,
                    'area_id' => Area::first()->id,
                    'address_en' => 'Branch Address ' . $b,
                    'address_ar' => 'عنوان الفرع ' . $b,
                    'category_id' => null,
                    'longitude' => '26.1110447',
                    'latitude' => '50.6207331',
                ]);
                $branch->work_time()->create([
                    'from' => '9:00',
                    'to' => '18:00',
                    'duration' => 30,
                    'days' => 'Sun,Mon,Tue,Wed,Thu'
                ]);
                $branch->contact()->create([
                    'facebook_link' => 'https://www.google.com/',
                    'whatsapp_number' => '01124579105',
                    'country_code' => '+973',
                    'phone' => '01124579105',
                    'website' => 'https://www.google.com/',
                    'instagram_link' => 'https://www.google.com/',
                ]);
                $branch->organization_users()->create([
                    'user_name' => 'Agency branch user ' . $b,
                    'email' => 'ba' . $main_key . $b . '@gmail.com',
                    'password' => "123456",
                ]);
                $branch->available_vehicles()->attach($vehicles);
                $branch->available_products()->attach($products);
                $branch->available_services()->attach($service_offer->id);
                $branch->payment_methods()->attach($payment_methods);
                $branch->phones()->create([
                    'country_code' => '+973',
                    'phone' => $phone[array_rand($phone)],
                    'title_en' => $name_en[$b],
                    'title_ar' => $name_ar[$b]
                ]);

            }
        }


    }
}
