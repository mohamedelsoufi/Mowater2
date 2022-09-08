<?php

namespace Database\Seeders;

use App\Models\AdType;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

use App\Models\Brand;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;
use App\Models\MainVehicle;
use App\Models\Color;
use App\Models\PaymentMethod;
use App\Models\Wench;
use App\Models\CarModel;
use App\Models\Category;

class WenchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $logos = ['m26.png', 'm27.png', 'm28.jpg', 'm29.png', 'm30.jpg', 'm31.png', 'm32.png', 'm33.jpg', 'm34.png'];
        $users = ['wench1@gmail.com', 'wench2@gmail.com', 'wench3@gmail.com', 'wench4@gmail.com', 'wench5@gmail.com', 'wench6@gmail.com', 'wench7@gmail.com', 'wench8@gmail.com', 'wench9@gmail.com'];
        $names = [
            'سطحه الزلاق',
            'سطحة هيدروليك',
            'ونش سطحه كرين',
            'ونش سطحه كرين',
            'سطحة مدنية حمد سوق واقف',
            'سطحه الرفاع ',
            'سطحه سلماباد',
            'سطحه المنامه توبلي',
            'سطحه عالي',
        ];
        $types = ['wench', 'rooftop_vehicle'];
        $location_types = ['local', 'national'];
        $cities = [1, 1, 1, 2, 2, 2, 3, 3, 3];
        $areas = [2, 1, 3, 5, 7, 9, 12, 14, 16];
        $is_negotiable = [0, 1];
        $latitude = [26.272000796341498, 26.270216847142375, 26.253229632066255, 26.251697684229384, 26.157647543080333, 26.166280976206604, 26.23497075677935, 26.230509827061823, 26.198181469967928];
        $longitude = [50.608592796488196, 50.660938764298095, 50.639560239345236, 50.612485490810705, 50.615971680574404, 50.61789220399404, 50.584777595800475, 50.527987108377175, 50.545917683401456];
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];
        $price = [500, 1000, 1500, 2000, 2300];

        $images = ['p1.jpg', 'p2.jpg', 'p3.jpg', 'p4.jpg', 'p5.jpg', 'p6.jpg', 'p7.jpg', 'p8.jpg', 'p9.jpg', 'p10.jpg',];

        for ($counter = 0; $counter < 9; $counter++) {
            $wench = Wench::create([
                'name_en' => 'Wench' . $counter,
                'name_ar' => $names[$counter],
                'description_en' => 'First thing first, as is the case with every special edition these days, you get lots of 70th anniversary badging on your Corvette.',
                'description_ar' => 'علنت شركة موترسيتي، الوكيل الحصري لسيارات شيري في مملكة البحرين، عن إطلاقها الرسمي للجيل الجديد من سياراتها الرياضية متعددة الأغراضTiggo Pro  وذلك في معرض موترسيتي بسند. ',
                'tax_number' => 'w' . rand(1000, 1000000),
                'logo' => 'seeder/' . $logos[$counter],
                'active' => 1,
                'available' => 1,
                'reservation_availability' => 1,
                'delivery_availability' => 1,
                'reservation_active' => 1,
                'delivery_active' => 1,
                'country_id' => Country::where('name_en', 'Bahrain')->first()->id,
                'city_id' => $cities[$counter],
                'area_id' => $areas[$counter],
                'year_founded' => '1990',
                'status' => 'available',
                'wench_type' => $types[array_rand($types)],
                'location_type' => $location_types[array_rand($location_types)],
                'latitude' => $latitude[$counter],
                'longitude' => $longitude[$counter],
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $wench->payment_methods()->attach($payment_methods);

            $wench->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $wench->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $names[$counter],
                'title_ar' => $names[$counter]
            ]);

            $wench->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);


            $wench->organization_users()->create([
                'user_name' => 'wench user ' . $counter,
                'email' => $users[$counter],
                'password' => "123456",
            ]);

            $wench->discount_cards()->attach(1);

            $service_categories = Category::where('ref_name', 'services')->where('section_id', 5)->get();

            foreach ($service_categories as $category) {
                $sub_categories = SubCategory::where('category_id', $category->id)->get();
                foreach ($sub_categories as $sub_category) {
                    $service_offer = $wench->services()->create([
                        'name_en' => $sub_category->name_en,
                        'name_ar' => $sub_category->name_ar,
                        'description_en' => 'description of ' . $sub_category->name_en,
                        'description_ar' => 'وصف لـ ' . $sub_category->name_ar,
                        'price' => 2500,
                        'category_id' => $sub_category->category_id,
                        'sub_category_id' => $sub_category->id,
                        'location_required' => true,
                    ]);
                    $service_offer->offers()->create([
                        'discount_card_id' => 1,
                        'discount_type' => 'amount',
                        'discount_value' => 200,
                        'number_of_uses_times' => 'endless',
                        'notes' => 'خصم 200 درهم على التالي',
                    ]);
                }
            }
        }
    }
}
