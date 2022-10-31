<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RentalProperty;
use Illuminate\Database\Seeder;

use App\Models\Brand;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;
use App\Models\MainVehicle;
use App\Models\Color;
use App\Models\PaymentMethod;
use App\Models\RentalOffice;
use App\Models\CarModel;
use App\Models\CarClass;

class RentalOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $logos = ['m7.png', 'm8.png', 'm9.jpg', 'm10.jpg', 'm11.jpg', 'm12.jpg'];
        $users = ['r1@gmail.com', 'r2@gmail.com', 'r3@gmail.com', 'r4@gmail.com', 'r5@gmail.com', 'r6@gmail.com'];
        $names = ['مكتب تأجير الزهيدي', 'مكتب تأجير البلوشي', 'مكتب تأجير إكزوتكس', 'مكتب تأجير الأهلي', 'مكتب تأجير البندر', 'مكتب تأجير الريان',];
        $manufacturing_year = ['2018', '2019', '2020', '2021', '2022', '2017'];
        $vehicle_type = array_keys(rental_car_types_arr());
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];
        $discount_value = ['', '10', '20', '', '30'];

        $vehicle_images = [];
        for ($i = 1; $i <= 30; $i++) {
            array_push($vehicle_images, "seeder/v$i.jpg");
        }


        for ($counter = 0; $counter < 6; $counter++) {
            $office = RentalOffice::create([
                'name_en' => 'Rental Office' . $counter,
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

            $payment_methods = PaymentMethod::pluck('id');
            $office->payment_methods()->attach($payment_methods);

            $office->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $office->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $names[$counter],
                'title_ar' => $names[$counter]
            ]);

            $office->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $org_user = $office->organization_users()->create([
                'user_name' => 'rental user ' . $counter,
                'email' => $users[$counter],
                'password' => "123456",
            ]);

            $org_role = $office->roles()->create([
                'name_en' => 'Organization super admin' .' '. $office->name_en,
                'name_ar' => 'صلاحية المدير المتميز' .' '. $office->name_ar,
                'display_name_ar' => 'صلاحية المدير المتميز' .' '. $office->name_ar,
                'display_name_en' => 'Organization super admin' .' '. $office->name_en,
                'description_ar' => 'له جميع الصلاحيات',
                'description_en' => 'has all permissions',
                'is_super' => 1,
            ]);

            foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
                foreach ($values as $value) {
                    $permission = Permission::create([
                        'name' => $value . '-' . $key.'-'. $office->name_en,
                        'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $office->name_ar,
                        'display_name_en' => $value . ' ' . $key . ' ' . $office->name_en,
                        'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $office->name_ar,
                        'description_en' => $value . ' ' . $key . ' ' . $office->name_en,
                    ]);
                    $org_role->attachPermissions([$permission]);
                }
            }

            $org_user->attachRole($org_role);

            $office->rental_laws()->create([
                'title_en' => 'Smoking was allowed in our car. If you smoke in one of our cars, additional cleaning costs will be charged to your account.',
                'title_ar' => 'سمح التدخين في سيارتنا. وفي حالة قيامك بالتدخين في إحدى سياراتنا، سيتم إحتساب تكاليف تنظيف إضافية على حسابك.',
            ]);

            $office->rental_laws()->create([
                'title_en' => 'It is not permissible to rent one way.',
                'title_ar' => 'لا يجوز التأجير لطريق واحد.',
            ]);

            $office->payment_methods()->attach(PaymentMethod::first()->id);

            $office->payment_methods()->attach(PaymentMethod::skip(1)->first()->id);

            $office->discount_cards()->attach(1);



            for ($i = 0; $i < 8; $i++) {
                $brand = Brand::inRandomOrder()->first()->id;
                $discount = $discount_value[array_rand($discount_value)];
                $dis_type = ['percentage', 'amount'];
                $cars = $office->rental_office_cars()->create([
                    'vehicle_type' => $vehicle_type[array_rand($vehicle_type)],
                    'brand_id' => $brand,
                    'car_model_id' => CarModel::where('brand_id',$brand)->first()->id,
                    'car_class_id' => CarClass::inRandomOrder()->first()->id,
                    'manufacture_year' => $manufacturing_year[array_rand($manufacturing_year)],
                    'color_id' => Color::inRandomOrder()->first()->id,
                    'daily_rental_price' => mt_rand(50,150),
                    'weekly_rental_price' => mt_rand(300,500),
                    'monthly_rental_price' => mt_rand(4000,10000),
                    'yearly_rental_price' => mt_rand(10000,50000),
                    'discount' => $discount,
                    'discount_type' => $discount != '' ? $dis_type[array_rand($dis_type)] : '',
                ]);
                $properties = RentalProperty::inRandomOrder()->take(3)->pluck('id');
                $cars->properties()->attach($properties);


                for ($q = 0; $q < 4; $q++) {
                    $cars->files()->create([
                        'path' => $vehicle_images[array_rand($vehicle_images)],
                        'type' => 'vehicle_image',
                        'color_id' => $q <= 1 ? Color::first()->id : Color::skip(1)->first()->id,
                    ]);
                }

                $cars->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 5,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 5 % على التالي',
                ]);
            }

            for ($b = 0; $b < 4; $b++) {
                $city = City::inRandomOrder()->first()->id;
                $branch = $office->branches()->create([
                    'name_en' => $office->name_en . ' Branch ' . $b,
                    'name_ar' => $office->name_ar . ' فرع ' . $b,
                    'country_id' => 1,
                    'city_id' => $city,
                    'area_id' => Area::where('city_id',$city)->first()->id,
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
                $branch_user = $branch->organization_users()->create([
                    'user_name' => 'Rental office branch user ' . $b,
                    'email' => 'bac' . $counter . $b . '@gmail.com',
                    'password' => "123456",
                ]);

                $branch_role = $branch->roles()->create([
                    'name_en' => 'super admin' .' '. $office->name_en.' '.$branch->name_en,
                    'name_ar' => 'صلاحية المدير المتميز' .' '.$office->name_en.' '. $branch->name_ar,
                    'display_name_ar' => 'صلاحية المدير المتميز' .' '. $branch->name_ar,
                    'display_name_en' => 'super admin' .' '. $branch->name_en,
                    'description_ar' => 'له جميع الصلاحيات',
                    'description_en' => 'has all permissions',
                    'is_super' => 1,
                ]);

                foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
                    foreach ($values as $value) {
                        $permission = Permission::create([
                            'name' => $value . '-' . $key.'-'.$branch->name_en,
                            'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $branch->name_ar,
                            'display_name_en' => $value . ' ' . $key . ' ' . $branch->name_en,
                            'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $branch->name_ar,
                            'description_en' => $value . ' ' . $key . ' ' . $branch->name_en,
                        ]);
                        $branch_role->attachPermissions([$permission]);
                    }
                }

                $branch_user->attachRole($branch_role);

                $vehicles = $office->rental_office_cars()->pluck('id');
                $branch->available_rental_cars()->attach($vehicles);
                $branch->payment_methods()->attach($payment_methods);
                $branch->phones()->create([
                    'country_code' => '+973',
                    'phone' => $phone[array_rand($phone)],
                    'title_en' => $branch->name_en,
                    'title_ar' =>  $branch->name_ar
                ]);
            }
        }



    }
}
