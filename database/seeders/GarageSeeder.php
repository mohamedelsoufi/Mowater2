<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\Permission;
use Illuminate\Database\Seeder;

use App\Models\Brand;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;
use App\Models\Garage;
use App\Models\CarModel;
use App\Models\Category;

class GarageSeeder extends Seeder
{
    public function run()
    {

        $logos = ['m16.png', 'm17.jpg', 'm18.png', 'm19.png', 'm20.jpg', 'm21.jpg', 'm22.jpg', 'm23.png', 'm24.jpg'];
        $users = ['g1@gmail.com', 'g2@gmail.com', 'g3@gmail.com', 'g4@gmail.com', 'g5@gmail.com', 'g6@gmail.com', 'g7@gmail.com', 'g8@gmail.com', 'g9@gmail.com'];
        $names = ['كراج بحرين لاين', 'كراج الزيمور', 'كراج بن ضيف', 'كراج أبو حسن', 'كراج جلوبل', 'كراج زهير للسمكره', 'كراج أوال - السلمانية', 'كراج الانصاري 27', 'كراج الرمال الذهبية'];

        $images = ['p1.jpg', 'p2.jpg', 'p3.jpg', 'p4.jpg', 'p5.jpg', 'p6.jpg', 'p7.jpg', 'p8.jpg', 'p9.jpg', 'p10.jpg',];
        $types = ['original', 'commercial'];
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468'];
        $is_negotiable = [0, 1];
        $price = [500, 1000, 1500, 2000, 2300];
        $manufacturing_year = ['2020', '2021', '2022'];
        $car_class = [1, 2, 3];
        $is_new = [0, 1];

        for ($counter = 0; $counter < 9; $counter++) {
            $office = Garage::create([
                'name_en' => 'Garage' . $counter,
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

            $office->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);

            $office->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $names[$counter],
                'title_ar' => $names[$counter]
            ]);


            $org_user = $office->organization_users()->create([
                'user_name' => 'garage user ' . $counter,
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

            $office->discount_cards()->attach(1);

            $categories = Category::where('section_id', 7)->inRandomOrder()->get();
            foreach ($categories as $category) {
                $office->categories()->attach($category->id);
                $brands = Brand::all();
                foreach ($brands as $brand) {
                    $car_models = CarModel::where('brand_id', $brand->id)->get();
                    foreach ($car_models as $car_model) {

                        $p = $office->products()->create([
                            'name_en' => 'Lemforder Strut Mounts' . ' ' . $brand->name_en,
                            'name_ar' => $brand->name_ar . ' ' . 'جوان وش سلندر اصلي',
                            'description_en' => 'Lemforder Strut Mounts' . ' ' . $brand->name_en . ', ' . $car_model->name_en,
                            'description_ar' => $brand->name_ar . ', ' . $car_model->name_ar . ' ' . 'جوان وش سلندر اصلي',
                            'brand_id' => $car_model->brand_id,
                            'car_model_id' => $car_model->id,
                            'car_class_id' => $car_class[array_rand($car_class)],
                            'manufacturing_year' => $manufacturing_year[array_rand($manufacturing_year)],
                            'price' => $car_model->id * 6,
                            'status' => 'جيدة',
                            'type' => $types[array_rand($types)],
                            'is_new' => $is_new[array_rand($is_new)],
                            'category_id' => $category->id,
                            'sub_category_id' => $category->sub_categories()->first()->id,
                            'warranty_value' => $car_model->id > 3 ? null : '3 months',
                        ]);

                        $p->offers()->create([
                            'discount_card_id' => 1,
                            'discount_type' => 'amount',
                            'discount_value' => 200,
                            'number_of_uses_times' => 'endless',
                            'notes' => 'خصم 200 درهم على التالي',
                        ]);

                        $p->files()->create([
                            'path' => 'seeder/' . $images[array_rand($images)],
                        ]);

                        $p->files()->create([
                            'path' => 'seeder/' . $images[array_rand($images)],
                        ]);

                        $s = $office->services()->create([
                            'name_en' => $category->name_en . ' ' . $brand->name_en,
                            'name_ar' => $category->name_ar . ' ' . $brand->name_ar,
                            'description_en' => $category->name_en . ' ' . $brand->name_en . ', ' . $car_model->name_en,
                            'description_ar' => $category->name_ar . ' ' . $brand->name_ar . ', ' . $car_model->name_ar,
                            'price' => $car_model->id * 500,
                            'category_id' => $category->id,
                            'sub_category_id' => $category->sub_categories()->first()->id,
                        ]);
                        $s->offers()->create([
                            'discount_card_id' => 1,
                            'discount_type' => 'amount',
                            'discount_value' => 200,
                            'number_of_uses_times' => 'endless',
                            'notes' => 'خصم 200 درهم على التالي',
                        ]);

                        $s->files()->create([
                            'path' => 'seeder/' . $images[array_rand($images)],
                        ]);

                        $s->files()->create([
                            'path' => 'seeder/' . $images[array_rand($images)],
                        ]);
                    }

                }
            }

        }
    }
}
