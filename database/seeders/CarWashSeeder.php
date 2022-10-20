<?php

namespace Database\Seeders;

use App\Models\CarWash;
use App\Models\Category;
use App\Models\City;
use App\Models\PaymentMethod;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class CarWashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name_ar = 'مغسلة وتلميع وسرفيس السيارات ';
        $name_en = 'Car wash, polishing and service ';
        $description_ar = 'تفاصيل مغسلة وتلميع وسرفيس السيارات ';
        $description_en = 'Details of Car wash, polishing and service ';
        $cities = City::all();
        $logo = ['car_wash1.png', 'car_wash2.jpg', 'car_wash3.jpg', 'car_wash4.jpg', 'car_wash5.png',];
        $service_images = ['washService1.jpg', 'washService2.jpg', 'washService3.jpg',
            'washService4.jpg', 'washService5.jpg', 'washService6.jpg', 'washService7.jpg', 'washService8.jpg',];
        $is_negotiable = [0, 1];
        $price = [1598753, 3578951, 258963, 147852, 147986325];
        $discount_value = ['', '10', '20', '', '30'];

        foreach ($cities as $key => $city) {
            $car_wash = CarWash::create([
                'logo' => 'seeder/' . $logo[$key],
                'name_en' => $name_en . $key,
                'name_ar' => $name_ar . $key,
                'description_en' => $description_en . $key,
                'description_ar' => $description_ar . $key,
                'tax_number' => mt_rand(15987, 35789),
                'city_id' => $city->id,
                'address' => '5 شارع اللملكة',
            ]);
            for ($t = 0; $t < 5; $t++) {
                $discount = $discount_value[array_rand($discount_value)];
                $dis_type = ['percentage', 'amount'];
                $services = $car_wash->carWashServices()->create([
                    'name_en' => 'Service name ' . $t,
                    'name_ar' => 'خدمة ' . $t,
                    'description_en' => 'Service description ' . $t,
                    'description_ar' => 'وصف خدمة ' . $t,
                    'price' => mt_rand(550, 9526),
                    'discount' => $discount,
                    'discount_type' => $discount != '' ? $dis_type[array_rand($dis_type)] : '',
                ]);
                for ($s = 0; $s < 5; $s++) {
                    $services->files()->create([
                        'path' => 'seeder/' . $service_images[array_rand($service_images)],
                        'type' => 'car_wash',
                    ]);
                }

            }
            $car_wash->discount_cards()->attach(1);
            $car_wash->categories()->attach(Category::where('section_id', 10)->inRandomOrder()
                ->first()->id);

            $center_services = $car_wash->carWashServices()->where('discount_type', '')->get();

            foreach ($center_services as $service) {
                $service->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 77,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 77 % على التالي',
                ]);
                $service->work_time()->create([
                    'from' => '08:00:00',
                    'to' => '17:00:00',
                    'duration' => '30',
                    'days' => 'Sun,Mon,Tue,Wed,Thu',
                ]);
            }
            $car_wash->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $car_wash->payment_methods()->attach($payment_methods);

            $car_wash->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $org_user = $car_wash->organization_users()->create([
                'user_name' => $name_en . ' ' . $key,
                'email' => 'car_wash' . $key . '@gmail.com',
                'password' => "123456",
            ]);

            $org_role = $car_wash->roles()->create([
                'name_en' => 'Organization super admin' . ' ' . $car_wash->name_en . $key,
                'name_ar' => 'صلاحية المدير المتميز' . ' ' . $car_wash->name_ar . $key,
                'display_name_ar' => 'صلاحية المدير المتميز' . ' ' . $car_wash->name_ar,
                'display_name_en' => 'Organization super admin' . ' ' . $car_wash->name_en,
                'description_ar' => 'له جميع الصلاحيات',
                'description_en' => 'has all permissions',
                'is_super' => 1,
            ]);

            foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
                foreach ($values as $value) {
                    $permission = Permission::create([
                        'name' => $value . '-' . $key . '-' . $car_wash->name_en . $key,
                        'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $car_wash->name_ar,
                        'display_name_en' => $value . ' ' . $key . ' ' . $car_wash->name_en,
                        'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $car_wash->name_ar,
                        'description_en' => $value . ' ' . $key . ' ' . $car_wash->name_en,
                    ]);
                    $org_role->attachPermissions([$permission]);
                }
            }

            $org_user->attachRole($org_role);

        }

    }
}
