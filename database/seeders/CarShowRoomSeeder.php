<?php

namespace Database\Seeders;

use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use App\Models\CarShowroom;
use App\Models\Brand;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;
use App\Models\Color;


class CarShowRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $logos = ['m1.png', 'm2.jpg', 'm3.jpg', 'm4.png', 'm5.jpg', 'm6.jpg'];
        $users = ['m1@gmail.com', 'm2@gmail.com', 'm3@gmail.com', 'm4@gmail.com', 'm5@gmail.com', 'm6@gmail.com'];
        $branch_users = ['bm1@gmail.com', 'bm2@gmail.com', 'bm3@gmail.com', 'bm4@gmail.com'];

        $names = [
            'الزهيدي لتجارة السيارات',
            'البلوشي للسيارات المستعملة',
            'إكزوتكس للسيارات',
            'الأهلي للسيارات',
            'البندر للسيارات',
            'الريان للسيارات',
        ];
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];

        $vehicle_images = [];
        for ($i = 1; $i <= 30; $i++) {
            array_push($vehicle_images, "seeder/v$i.jpg");
        }

        for ($counter = 0; $counter < 5; $counter++) {
            $car_show_room = CarShowRoom::create([
                'name_en' => 'Car Show Room' . $counter,
                'name_ar' => $names[$counter],
                'description_en' => 'First thing first, as is the case with every special edition these days, you get lots of 70th anniversary badging on your Corvette.',
                'description_ar' => 'علنت شركة موترسيتي، الوكيل الحصري لسيارات شيري في مملكة البحرين، عن إطلاقها الرسمي للجيل الجديد من سياراتها الرياضية متعددة الأغراضTiggo Pro  وذلك في معرض موترسيتي بسند. ',
                'tax_number' => '756436',
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

            $car_show_room->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $car_show_room->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $names[$counter],
                'title_ar' => $names[$counter]
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $car_show_room->payment_methods()->attach($payment_methods);

            $car_show_room->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $car_show_room->organization_users()->create([
                'user_name' => 'car user ' . $counter,
                'email' => $users[$counter],
                'password' => "123456",
            ]);
            $car_show_room->discount_cards()->attach(1);

            $brands = Brand::pluck('id')->toArray();
            $car_models = CarModel::pluck('id')->toArray();
            $car_classes = CarClass::pluck('id')->toArray();
            $manufacturing_year = ['2018', '2019', '2020', '2021', '2022'];
            $is_new = [0, 1];
            $traveled_distance = [25000, 30000, 100000, 150000, 200000];
            $traveled_distance_type = ['km', 'mile'];
            $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
            $year = ['2021', '2022', '2023', '2024', '2025'];
            $color = [1, 2];
            $doors_number = [4, 2];
            $price = [1598753, 3578951, 258963, 147852, 147986325];
            $threeD = ['seeder/1.glb', 'seeder/2.glb'];

            $vehicle_type = ['cars', 'motorcycles', 'trucks','pickups'];
            $ghamara_count = '';
            if ($vehicle_type[array_rand($vehicle_type)]=='pickups') {
                $ghamara_count = array_rand(ghamara_count_arr());
            }
            for ($i = 0; $i < 4; $i++) {
                $vehicle = $car_show_room->vehicles()->create([
                    'vehicle_type' => $vehicle_type[array_rand($vehicle_type)],
                    'brand_id' => $brands[array_rand($brands)],
                    'car_model_id' => $car_models[array_rand($car_models)],
                    'car_class_id' => $car_classes[array_rand($car_classes)],
                    'manufacturing_year' => $manufacturing_year[array_rand($manufacturing_year)],
                    'is_new' => 1,
                    'traveled_distance' => $traveled_distance[array_rand($traveled_distance)],
                    'traveled_distance_type' => $traveled_distance_type[array_rand($traveled_distance_type)],
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
                    'status' => array_rand(status_arr()),
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
                    'selling_by_plate' => array_rand($is_new),
                    'number_plate' => '',
                    'price_is_negotiable' => array_rand($is_new),
                    'location' => '',
                    'additional_notes' => '',
                    'price' => $price[array_rand($price)],
                    'availability' => array_rand($is_new),
                    'active' => array_rand($is_new),
                ]);

                for ($q = 0; $q < 4; $q++) {
                    $vehicle->files()->create([
                        'path' => $vehicle_images[array_rand($vehicle_images)],
                        'type' => 'vehicle_image',
                        'color_id' => $q <= 1 ? Color::first()->id : Color::skip(1)->first()->id,
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
            }

            $vehicles = $car_show_room->vehicles()->pluck('id');

            for ($b = 0; $b < 4; $b++) {
                $branch = $car_show_room->branches()->create([
                    'name_en' => 'Branch 1',
                    'name_ar' => 'فرع 1',
                    'area_id' => Area::first()->id,
                    'address_en' => 'Branch 1 Address',
                    'address_ar' => 'عنوان الفرع الأول',
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
                    'user_name' => 'car showroom branch user ' . $b,
                    'email' => 'bm' . $counter . $b . '@gmail.com',
                    'password' => "123456",
                ]);
                $branch->available_vehicles()->attach($vehicles);
                $branch->payment_methods()->attach($payment_methods);
                $branch->phones()->create([
                    'country_code' => '+973',
                    'phone' => $phone[array_rand($phone)],
                    'title_en' => $names[$b],
                    'title_ar' => $names[$b]
                ]);
            }
        }





    }
}
