<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\PaymentMethod;
use App\Models\Permission;
use App\Models\TireExchangeCenter;
use Illuminate\Database\Seeder;

class TireExchangeCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name_ar = 'مركز تبديل الإطارات ';
        $name_en = 'Tire Exchange Center ';
        $description_ar = 'تفاصيل مركز تبديل الإطاراتي ';
        $description_en = 'Details of Tire Exchange Center ';
        $cities = City::all();
        $service_images = ['tire1.jpg', 'tire2.jpg', 'tire3.jpg', 'tire4.jpg', 'tire5.jpg',];

        $logo = ['logo_tire1.jpg', 'logo_tire2.jpg', 'logo_tire3.jpg', 'logo_tire4.jpg', 'logo_tire5.jpg',];

        foreach ($cities as $key => $city) {
            $tire_exchange_center = TireExchangeCenter::create([
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
                $services = $tire_exchange_center->tireExchangeService()->create([
                    'name_en' => 'Service name ' . $t,
                    'name_ar' => 'خدمة ' . $t,
                    'description_en' => 'Service description ' . $t,
                    'description_ar' => 'وصف خدمة ' . $t,
                    'price' => mt_rand(550, 9526)
                ]);
                for ($s = 0; $s < 5; $s++) {
                    $services->files()->create([
                        'path' => 'seeder/' . $service_images[array_rand($service_images)],
                        'type' => 'tire_exchange_center',
                    ]);
                }

            }
            $tire_exchange_center->discount_cards()->attach(1);


            $center_services = $tire_exchange_center->tireExchangeService;

            foreach ($center_services as $service) {
                $service->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 69,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 69 % على التالي',
                ]);
            }
            $tire_exchange_center->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $tire_exchange_center->payment_methods()->attach($payment_methods);

            $tire_exchange_center->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $org_user = $tire_exchange_center->organization_users()->create([
                'user_name' => $name_en . ' ' . $key,
                'email' => 'tire_exchange' . $key . '@gmail.com',
                'password' => "123456",
            ]);

            $org_role = $tire_exchange_center->roles()->create([
                'name_en' => 'Organization super admin' .' '. $tire_exchange_center->name_en. $key,
                'name_ar' => 'صلاحية المدير المتميز' .' '. $tire_exchange_center->name_ar. $key,
                'display_name_ar' => 'صلاحية المدير المتميز' .' '. $tire_exchange_center->name_ar,
                'display_name_en' => 'Organization super admin' .' '. $tire_exchange_center->name_en,
                'description_ar' => 'له جميع الصلاحيات',
                'description_en' => 'has all permissions',
                'is_super' => 1,
            ]);

            foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
                foreach ($values as $value) {
                    $permission = Permission::create([
                        'name' => $value . '-' . $key.'-'. $tire_exchange_center->name_en. $key,
                        'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $tire_exchange_center->name_ar,
                        'display_name_en' => $value . ' ' . $key . ' ' . $tire_exchange_center->name_en,
                        'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $tire_exchange_center->name_ar,
                        'description_en' => $value . ' ' . $key . ' ' . $tire_exchange_center->name_en,
                    ]);
                    $org_role->attachPermissions([$permission]);
                }
            }

            $org_user->attachRole($org_role);

        }

    }
}
