<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\MiningCenter;
use App\Models\PaymentMethod;
use App\Models\Permission;
use App\Models\TireExchangeCenter;
use Illuminate\Database\Seeder;

class MiningCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name_ar = 'مركز التلغيم ومزودي الطاقة ';
        $name_en = 'Mining Center and Energy Providers ';
        $description_ar = 'مركز التلغيم ومزودي الطاقة ';
        $description_en = 'Details of Mining Center and Energy Providers ';
        $cities = City::all();
        $service_images = ['mining_service1.jpg', 'mining_service2.jpg', 'mining_service3.jpg',
            'mining_service4.jpg', 'mining_service5.jpg','mining_service6.jpg','mining_service7.jpg'];

        $logo = ['mining1.jpg', 'mining2.jpg', 'mining3.jpg', 'mining4.jpg', 'mining5.jpg',];
        $discount_value = ['', '10', '20', '', '30'];

        foreach ($cities as $key => $city) {
            $mining_center = MiningCenter::create([
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
                $services = $mining_center->miningCenterService()->create([
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
                        'type' => 'mining_center',
                    ]);
                }

            }
            $mining_center->discount_cards()->attach(1);


            $center_services = $mining_center->miningCenterService()->where('discount_type', '')->get();

            foreach ($center_services as $service) {
                $service->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 45,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 45 % على التالي',
                ]);
            }
            $mining_center->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $mining_center->payment_methods()->attach($payment_methods);

            $mining_center->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $org_user = $mining_center->organization_users()->create([
                'user_name' => $name_en . ' ' . $key,
                'email' => 'mining_center' . $key . '@gmail.com',
                'password' => "123456",
            ]);

            $org_role = $mining_center->roles()->create([
                'name_en' => 'Organization super admin' .' '. $mining_center->name_en. $key,
                'name_ar' => 'صلاحية المدير المتميز' .' '. $mining_center->name_ar. $key,
                'display_name_ar' => 'صلاحية المدير المتميز' .' '. $mining_center->name_ar,
                'display_name_en' => 'Organization super admin' .' '. $mining_center->name_en,
                'description_ar' => 'له جميع الصلاحيات',
                'description_en' => 'has all permissions',
                'is_super' => 1,
            ]);

            foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
                foreach ($values as $value) {
                    $permission = Permission::create([
                        'name' => $value . '-' . $key.'-'. $mining_center->name_en. $key,
                        'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $mining_center->name_ar,
                        'display_name_en' => $value . ' ' . $key . ' ' . $mining_center->name_en,
                        'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $mining_center->name_ar,
                        'description_en' => $value . ' ' . $key . ' ' . $mining_center->name_en,
                    ]);
                    $org_role->attachPermissions([$permission]);
                }
            }

            $org_user->attachRole($org_role);

        }

    }
}
