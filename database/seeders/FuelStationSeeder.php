<?php

namespace Database\Seeders;

use App\Models\FuelStation;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class FuelStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logos = ['lulu.jpg', 'galali.jpg', 'yateem.jpg', 'sitra.jpg', 'sanabis.jpg', 'busaiteen.jpg'];
        $users = ['lulu@gmail.com', 'galali@gmail.com', 'yateem@gmail.com', 'sitra@gmail.com', 'sanabis@gmail.com', 'busaiteen@gmail.com'];

        $name_en = ['Lulu Service Station', 'Galali Petrol Station', 'Yateem Gas Filling Station', 'Sitra Fuel Station',
            'Sanabis Gas Station', 'Busaiteen Fuel Station'];
        $name_ar = ['محطة وقود لولو', 'محطة وقود قلالي', 'محطة تعبئة غاز يتيم', 'محطة وقود سترة', 'محطة بنزين السنابس', 'محطة وقود البسيتين'];

        $address_en = ['6HFC+HCM, Manama, Bahrain', '7JJV+2P4, Galali, Bahrain', 'Al Zahara Ave, Manama, Bahrain', '5J84+524, Sitra, Bahrain',
            '6GHW+F6G, Avenue 28, Sanabis, Bahrain', '7J92+5JJ, Busaitian, Busaiteen, Bahrain'];
        $address_ar = ['6 HFC + HCM ، المنامة ، البحرين', '7JJV + 2P4 ، قلالي ، البحرين', 'شارع الزهراء ، المنامة ، البحرين', '5J84 + 524 ، سترة ، البحرين',
            '6GHW + F6G ، شارع 28 ، السنابس ، البحرين', '7J92 + 5JJ ، البسيتين ، البسيتين ، البحرين'];

        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];
        $fuel_types = 'good,excellent,super,Diesel';
        $cities = [4,5,4,3,4,4,1];
        $areas = [21,25,19,15,19,24,5];
        $is_negotiable = [0, 1];
        $latitude = [26.22425009519976, 26.280120122322085, 26.227280117815692, 26.16551069496235, 26.228833221650145, 26.268110817917705];
        $longitude = [50.57105635493158, 50.644403770276895, 50.58201755493157, 50.60510135493057, 50.5455741260956, 50.60155631260463];

        for ($f = 0; $f < 6; $f++) {
            $fuel_station = FuelStation::create([
                'name_en' => $name_en[$f],
                'name_ar' => $name_ar[$f],
                'address_en' => $address_en[$f],
                'address_ar' => $address_ar[$f],
                'fuel_types' => $fuel_types,
                'logo' => 'seeder/fuel_stations/' . $logos[$f],
                'country_id' => 1,
                'city_id' => $cities[$f],
                'area_id' => $areas[$f],
                'latitude' => $latitude[$f],
                'longitude' => $longitude[$f],
                'active' => 1,
                'available' => 1
            ]);

            $service_name_ar = [
                'تبديل الزيوت للمحرك وفلتر الزيت', 'تبديل زيوت التشحيم', 'ملء زيت القير', 'ملء ناقل الحركة الأتوماتيكي و الردياتير', 'فحص سائل المكابح (الفرامل) وماء المساحات', 'المكابح (الفرامل) والأعمال الميكانيكية', 'الغسيل اليدوي للمركبات',
                'الغسيل الآلي للمركبات', 'تغيير الإطارات وضبط زوايا العجل', 'خدمات تنظيف المركبات', 'خدمات تصليح المركبات', 'إكسسوارات المركبات', 'قطع الغيار', 'نافذة واحدة للحصول على احتياجات العناية بالمركبة', 'سياسة الأسعار الواحدة في جميع المتاجر',
            ];

            $service_name_en = [
                'Change engine oils and oil filter', 'Lubricant switch', 'Bitumen oil filling', 'Filling the automatic transmission and radiator',
                'Check brake fluid (brake) and wiper water', 'Brakes (brakes) and mechanical works', 'Manual Vehicle Wash', 'Auto wash for vehicles',
                'Change tires and adjust calf angles', 'Vehicle cleaning services', 'Vehicle repair services', 'Vehicle Accessories',
                'spare parts', 'One-stop-shop for your vehicle care needs', 'One price policy in all stores',
            ];
            $price = [120,125,130,135,140,145,150,155,160,165,170,175,180,158,122];

            for ($counter = 0; $counter < 2; $counter++) {
                $fuel_station->services()->create([
                    'name_en' => $service_name_en[$counter],
                    'name_ar' => $service_name_ar[$counter],
                    'description_ar' => 'تفاصيل لـ ' . $service_name_ar[$counter],
                    'description_en' => 'Description of ' . $service_name_en[$counter],
                    'price'=> $price[$counter]
                ]);
            }

            $fuel_station->work_time()->create([
                'from' => '09:00:00',
                'to' => '09:00:00',
                'duration' => '',
                'days' => 'Sun,Mon,Tue,Wed,Thu,Fri,Sat',
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $fuel_station->payment_methods()->attach($payment_methods);

            $fuel_station->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[$f],
                'title_en' => $name_en[$f],
                'title_ar' => $name_ar[$f]
            ]);

            $fuel_station->organization_users()->create([
                'user_name' => 'Fuel Station ' . $f,
                'email' => $users[$f],
                'password' => "123456",
            ]);

            $fuel_station->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => $phone[$f],
                'phone' => $phone[$f],
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

        }
    }
}
