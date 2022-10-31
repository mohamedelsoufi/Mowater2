<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\Permission;
use App\Models\TrafficClearingOffice;
use App\Models\TrafficClearingService;
use App\Models\TrafficClearingServiceUse;
use Illuminate\Database\Seeder;

class TrafficClearingOfficeSeeder extends Seeder
{

    public function run()
    {
        $name_en = ['Tasks for clearing transactions', 'Anwar Bahrain to clear transactions', 'Bo Anas for clearing government and real estate transactions'];
        $name_ar = ['المهام لتخليص المعاملات', 'انوار البحرين لتخليص المعاملات', 'بو انس لتخليص المعاملات الحكومية والعقارات', 'بو أنس لتخليص المعاملات الحكومية والعقارية'];

        $description_en = ['For those who do not have time to complete their transactions, we are an official institution for clearing tasks to clear transactions.',
            'Anwar Bahrain for clearing transactions To clear all government and official transactions',
            'Establishing companies, clearing transactions, real estate, business services and management consulting'];
        $description_ar = ['لمن لا يمتلكون الوقت لإنجاز معاملاتهم نحن مؤسسة رسمية لتخليص المهام لتخليص المعاملات.',
            'انوار البحرين لتخليص المعاملات لتخليص جميع المعاملات الحكومية والرسمية',
            'تأسيس شركات ٬ تخليص معاملات ٬ عقارات ٬ خدمات رجال الاعمال والاستشارات الإدارية '];

        $logos = ['seeder/tasks_for_clearing_transactions.jpg', 'default_image.png', 'seeder/boanas.jpg']; //'seeder/toyota-Logo.jpg'
        $users = ['traffic1@gmail.com', 'traffic2@gmail.com', 'traffic3@gmail.com'];
        $branch_users = ['tba1@gmail.com', 'tba2@gmail.com', 'tba3@gmail.com', 'tba4@gmail.com', 'tba5@gmail.com', 'tba6@gmail.com'];
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];

        $service_en=['Vehicle inspection','Pay fines','Vehicle registration or renewal',
            'Vehicle insurance','Transfer of vehicle ownership','Changing the plates'];
        $service_ar=['فحص المركبة','دفع المخالفات','تسجيل أو تجديد المركبة','تأمين المركبة','نقل ملكية المركبة','تغيير اللوحات'];
        $discount_value = ['', '10', '20', '', '30'];

        for ($counter = 0; $counter < 3; $counter++) {
            $traffic = TrafficClearingOffice::create([
                'name_en' => $name_en[$counter],
                'name_ar' => $name_ar[$counter],
                'description_en' =>$description_en[$counter],
                'description_ar' => $description_ar[$counter],
                'tax_number' => 756436 + $counter,
                'logo' => $logos[$counter],
                'active' => 1,
                'available' => 1,
                'reservation_availability' => 1,
                'reservation_active' => 1,
                'country_id' => Country::where('name_en', 'Bahrain')->first()->id,
                'city_id' => City::first()->id,
                'area_id' => Area::where('city_id', City::first()->id)->first()->id,
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $traffic->payment_methods()->attach($payment_methods);

            $traffic->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $traffic->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $name_en[$counter],
                'title_ar' => $name_ar[$counter]
            ]);

            $traffic->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $org_user = $traffic->organization_users()->create([
                'user_name' => $name_en[$counter],
                'email' => $users[$counter],
                'password' => "123456",
            ]);

            $org_role = $traffic->roles()->create([
                'name_en' => 'Organization super admin' .' '. $traffic->name_en.$counter,
                'name_ar' => 'صلاحية المدير المتميز' .' '. $traffic->name_ar.$counter,
                'display_name_ar' => 'صلاحية المدير المتميز' .' '. $traffic->name_ar,
                'display_name_en' => 'Organization super admin' .' '. $traffic->name_en,
                'description_ar' => 'له جميع الصلاحيات',
                'description_en' => 'has all permissions',
                'is_super' => 1,
            ]);

            foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
                foreach ($values as $value) {
                    $permission = Permission::create([
                        'name' => $value . '-' . $key.'-'. $traffic->name_en,
                        'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $traffic->name_ar,
                        'display_name_en' => $value . ' ' . $key . ' ' . $traffic->name_en,
                        'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $traffic->name_ar,
                        'description_en' => $value . ' ' . $key . ' ' . $traffic->name_en,
                    ]);
                    $org_role->attachPermissions([$permission]);
                }
            }

            $org_user->attachRole($org_role);

            $traffic->discount_cards()->attach(1);

            $services = TrafficClearingService::pluck('id');

            foreach ($services as $service){
                $discount = $discount_value[array_rand($discount_value)];
                $dis_type = ['percentage', 'amount'];
                $traffic->trafficServices()->attach($service,[
                    'fees' => 100,
                    'price' => mt_rand(1000,6000),
                    'discount' => $discount,
                    'discount_type' => $discount != '' ? $dis_type[array_rand($dis_type)] : '',
                ]);
            }


            $traffic_service_offers = TrafficClearingServiceUse::where('traffic_clearing_office_id',$traffic->id)->where('discount_type', '')->get();
            foreach ($traffic_service_offers as $type){
                $type->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 5,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 5 % على التالي',
                ]);
            }
            for ($b = 0; $b < 2; $b++) {
                $branch = $traffic->branches()->create([
                    'name_en' => $name_en[$counter] . 'Branch '. $b,
                    'name_ar' => $name_ar[$counter] . ' فرع ' . $b,
                    'area_id' => Area::first()->id,
                    'address_en' => 'Branch Address ' . $b,
                    'address_ar' => 'عنوان الفرع ' . $b,
                    'longitude' => '',
                    'latitude' => '',
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
                    'user_name' => 'traffic clearing branch user ' . $b,
                    'email' => 'tcb'. $counter .$b.'@gmail.com',
                    'password' => "123456",
                ]);

                $branch_role = $branch->roles()->create([
                    'name_en' => 'super admin' .' '. $traffic->name_en.' '.$branch->name_en. $b,
                    'name_ar' => 'صلاحية المدير المتميز' .' '.$traffic->name_ar.' '. $branch->name_ar. $b,
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

                $branch->available_products()->attach($services);
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
