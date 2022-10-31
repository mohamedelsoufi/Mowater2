<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DiscountCard;
use App\Models\PaymentMethod;
use App\Models\Permission;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use App\Models\SpecialNumberOrganization;
use App\Models\Brand;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;

class SpecialNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $logos = ['m14.jpg', 'm13.jpg', 'm15.jpg', 'm16.png', 'm17.jpg'];
        $users = ['s1@gmail.com', 's2@gmail.com', 's3@gmail.com', 's4@gmail.com', 's5@gmail.com'];
        $names = ['مؤسسة الزهيدي', 'مؤسسة البلوشي', 'مؤسسة إكزوتكس', 'مؤسسة الأهلي', 'مؤسسة البندر', 'مؤسسة الريان',];

        $numbers = [
            '7674', '8884', '11811', '28121', '488545', '717874', '74', '56', '245', '246', '1774',
            '8184', '80', '62', '247', '201', '1775', '8796', '47884', '13456', '385901', '405004',
            '7784', '8824', '12811', '28221', '487545', '716874', '71', '55', '248', '249', '1773',
            '8384', '81', '63', '235', '202', '1776', '8795', '47885', '13455', '385902', '405005', '7764', '8484', '13811',
            '28321', '486545', '715874', '72', '54', '255', '645', '1772',
            '8584', '82', '64', '745', '203', '1777', '8794', '47886', '13454', '385903', '405006', '7794', '8864', '14811',
            '28421', '485545', '714874', '73', '53', '145', '105', '1771',
            '8874', '83', '65', '238', '204', '1778', '8793', '47887', '13453', '385904', '405007', '7574', '8084', '15811',
            '28521', '484545', '713874', '75', '52', '250', '208', '1770',
            '8984', '84', '66', '252', '205', '1779', '8792', '47888', '13452', '385905', '405008'];

        $types = ['own', 'waiver'];
        $sizes = ['normal_plate', 'special_plate'];
        $is_special = [0, 1];

        $categories = Category::where('section_id', 4)->get();
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];
        $discount_value = ['', '10', '20', '', '30'];
        $number_of_uses_times = [2, 4, 1];


        for ($counter = 0; $counter < 5; $counter++) {
            $office = SpecialNumberOrganization::create([
                'name_en' => 'Special Number Organization' . $counter,
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

            $office->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $names[$counter],
                'title_ar' => $names[$counter]
            ]);

            $office->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $discount_card = DiscountCard::first();
            $counting = 0;
            foreach ($categories as $category) {
                $sub_cats = $category->sub_categories()->get();
                foreach ($sub_cats as $sub_cat) {
                    for ($i = 0; $i < 2; $i++) {
                        $discount = $discount_value[array_rand($discount_value)];
                        $dis_type = ['percentage', 'amount'];
                        $specia_number = $office->special_numbers()->create([
                            'category_id' => $category->id,
                            'sub_category_id' => $sub_cat->id,
                            'number' => $numbers[$counting],
                            'size' => $sizes[array_rand($sizes)],
                            'transfer_type' => $types[array_rand($types)],
                            'price' =>mt_rand(2000,40000),
                            'discount' => $discount,
                            'discount_type' => $discount != '' ? $dis_type[array_rand($dis_type)] : '',
                            'Include_insurance' => 1,
                            'is_special' => $is_special[array_rand($is_special)],
                            'availability' => 1
                        ]);
                        $payment_methods = PaymentMethod::pluck('id');
                        $specia_number->payment_methods()->attach($payment_methods);
                        $office->discount_cards()->attach($discount_card->id);

                        $counting++;
                    }

                }


            }

            $numbers_offers = $office->special_numbers()->where('discount_type', '')->get();
            foreach ($numbers_offers as $ser) {
                $dis_val = mt_rand(200,700);
                $ser->offers()->create([
                    'discount_card_id' => $discount_card->id,
                    'discount_type' => 'amount',
                    'discount_value' => $dis_val,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => $number_of_uses_times[array_rand($number_of_uses_times)],
                    'notes' => 'خصم '.$dis_val.' درهم على التالي',
                ]);
            }

            $org_user = $office->organization_users()->create([
                'user_name' => 'special number orgnization user ' . $counter,
                'email' => $users[$counter],
                'password' => "123456",
            ]);

            $org_role = $office->roles()->create([
                'name_en' => 'Organization super admin' . ' ' . $office->name_en,
                'name_ar' => 'صلاحية المدير المتميز' . ' ' . $office->name_ar,
                'display_name_ar' => 'صلاحية المدير المتميز' . ' ' . $office->name_ar,
                'display_name_en' => 'Organization super admin' . ' ' . $office->name_en,
                'description_ar' => 'له جميع الصلاحيات',
                'description_en' => 'has all permissions',
                'is_super' => 1,
            ]);

            foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
                foreach ($values as $value) {
                    $permission = Permission::create([
                        'name' => $value . '-' . $key . '-' . $office->name_en,
                        'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $office->name_ar,
                        'display_name_en' => $value . ' ' . $key . ' ' . $office->name_en,
                        'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $office->name_ar,
                        'description_en' => $value . ' ' . $key . ' ' . $office->name_en,
                    ]);
                    $org_role->attachPermissions([$permission]);
                }
            }

            $org_user->attachRole($org_role);
        }


    }
}
