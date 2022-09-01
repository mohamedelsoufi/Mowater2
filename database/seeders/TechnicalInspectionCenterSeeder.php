<?php

namespace Database\Seeders;

use App\Models\Categorizable;
use App\Models\Category;
use App\Models\City;
use App\Models\PaymentMethod;
use App\Models\TechnicalInspectionCenter;
use Illuminate\Database\Seeder;

class TechnicalInspectionCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name_ar = 'مركز الفحص الفني ';
        $name_en = 'Technical Inspection Center ';
        $description_ar = 'تفاصيل مركز الفحص الفني ';
        $description_en = 'Details of Technical Inspection Center ';
        $cities = City::all();

        $service_images = ['inspection1.jpg', 'inspection2.jpg', 'inspection3.jpg', 'inspection4.jpg', 'inspection5.jpg',];
        $logo = ['logo_inspection1.jpg', 'logo_inspection2.jpg', 'logo_inspection3.jpg', 'logo_inspection4.jpg', 'logo_inspection5.jpg',];

        foreach ($cities as $key => $city) {
            $technical_inspection_center = TechnicalInspectionCenter::create([
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
                $services = $technical_inspection_center->inspectionCenterService()->create([
                    'name_en' => 'Service name ' . $t,
                    'name_ar' => 'خدمة ' . $t,
                    'description_en' => 'Service description ' . $t,
                    'description_ar' => 'وصف خدمة ' . $t,
                    'price' => mt_rand(550, 9526)
                ]);
                for ($s = 0; $s < 5; $s++) {
                    $services->files()->create([
                        'path' => 'seeder/' . $service_images[array_rand($service_images)],
                        'type' => 'technical_inspection_center',
                    ]);
                }

            }
            $technical_inspection_center->discount_cards()->attach(1);
            $technical_inspection_center->categories()->attach(Category::where('section_id', 12)->inRandomOrder()
                ->first()->id);

            $center_services = $technical_inspection_center->inspectionCenterService;

            foreach ($center_services as $service){
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
                    'days' => 'Sat,Sun,Mon,Tue,Wed,Thu',
                ]);
            }
            $technical_inspection_center->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $technical_inspection_center->payment_methods()->attach($payment_methods);

            $technical_inspection_center->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sat,Sun,Mon,Tue,Wed,Thu',
            ]);

            $technical_inspection_center->organization_users()->create([
                'user_name' => $name_en . ' ' . $key,
                'email' => 'inspection_center' . $key . '@gmail.com',
                'password' => "123456",
            ]);

        }

    }
}
