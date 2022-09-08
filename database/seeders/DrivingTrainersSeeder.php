<?php

namespace Database\seeders;

use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\DrivingTrainer;
use App\Models\DrivingTrainerType;
use App\Models\PaymentMethod;
use App\Models\Section;
use App\Models\TrainingType;
use Illuminate\Database\Seeder;

class DrivingTrainersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = Brand::pluck('id')->toArray();
        $car_classes = CarClass::pluck('id')->toArray();

        $hour_price = Section::where('ref_name', 'DrivingTrainer')->first()->reservation_cost;
        $brand = $brands[array_rand($brands)];
        $car_model = CarModel::where('brand_id', $brand)->first();


        $name_en = ['Ahmed Salah', 'Mohamed Ahmed', 'Omnia Ahmed', 'Esraa Ahmed', 'Youssef Ahmed'];
        $name_ar = ['أحمد صلاح', 'محمد أحمد', 'أمنية أحمد', 'اسراء أحمد', 'يوسف أحمد'];
        $gender = ['male', 'male', 'female', 'female', 'male'];
        $description_en = ['Car driver training', 'motorcycle driver training', 'Car driver training', 'motorcycle driver training', 'Car driver training'];
        $description_ar = ['تدريب سواقه على السيارات', 'تدريب سائقي الدراجات النارية', 'تدريب سواقه على السيارات', 'تدريب سائقي الدراجات النارية', 'تدريب سواقه على السيارات'];
        $vehicle_type = ['cars', 'motorcycles', 'cars', 'motorcycles', 'cars'];
        $manufacturing_year = ['2019', '2011', '2020', '2000', '2018'];
        $birth_date = ['1993-07-23', '1993-08-20', '1995-05-30', '1994-01-30', '1996-02-26'];
        $conveyor_type = ['automatic', 'manual', 'manual', 'manual', 'automatic'];
        $profile_picture = ['seeder/trainer.jpg', 'seeder/male1.jpg', 'seeder/female1.jpg', 'seeder/female2.jpg', 'seeder/male2.jpg'];
        $users = ['driving_tr1@gmail.com', 'driving_tr2@gmail.com', 'driving_tr3@gmail.com', 'driving_tr4@gmail.com', 'driving_tr5@gmail.com'];
        $phone = ['3366 7714', '1311 2262', '1725 3470', '1773 2426', '3838 7468', ''];
        $is_negotiable = [0, 1];
        $price = [500, 1000, 1500, 2000, 2300];
        $vehicle_images = ['seeder/v1.jpg','seeder/sliders/second/9.jpg','seeder/v2.jpg','seeder/sliders/second/10.jpg','seeder/v3.jpg'];

        for ($i = 0; $i < 5; $i++) {
            $driving_trainer = DrivingTrainer::create([
                'name_en' => $name_en[$i],
                'name_ar' => $name_ar[$i],
                'gender' => $gender[$i],
                'description_en' => $description_en[$i],
                'description_ar' => $description_ar[$i],
                'vehicle_type' => $vehicle_type[$i],
                'country_id' => 1,
                'city_id' => 1,
                'area_id' => 1,
                'active' => 1,
                'available' => 1,
                'brand_id' => $brand,
                'car_model_id' => $car_model->id,
                'car_class_id' => $car_classes[array_rand($car_classes)],
                'hour_price' => $hour_price,
                'manufacturing_year' => $manufacturing_year[$i],
                'birth_date' => $birth_date[$i],
                'conveyor_type' => $conveyor_type[$i],
                'profile_picture' => $profile_picture[$i]
            ]);

            $driving_trainer->file()->create([
                'path' => $vehicle_images[$i],
                'type' => 'trainer_vehicle',
            ]);

            $payment_methods = PaymentMethod::pluck('id');
            $driving_trainer->payment_methods()->attach($payment_methods);

            $driving_trainer->discount_cards()->attach(1);

            $trainig_types= TrainingType::pluck('id')->toArray();
            foreach ($trainig_types as $trainig_type){
                $driving_trainer->types()->attach([$trainig_type]);
            }



            $driving_trainer_types = DrivingTrainerType::where('driving_trainer_id',$driving_trainer->id)->get();
            foreach ($driving_trainer_types as $type){
                $type->offers()->create([
                    'discount_card_id' => 1,
                    'discount_type' => 'percentage',
                    'discount_value' => 5,
                    'number_of_uses_times' => 'specific_number',
                    'specific_number' => 2,
                    'notes' => 'خصم 5 % على التالي',
                ]);
            }

            $driving_trainer->work_time()->create([
                'from' => '09:00:00',
                'to' => '17:00:00',
                'duration' => '60',
                'days' => 'Sun,Mon,Tue,Wed,Thu',
            ]);
            $driving_trainer->contact()->create([
                'facebook_link' => 'https://www.google.com/',
                'whatsapp_number' => '01124579105',
                'country_code' => '+973',
                'phone' => '01124579105',
                'website' => 'https://www.google.com/',
                'instagram_link' => 'https://www.google.com/',
            ]);

            $driving_trainer->phones()->create([
                'country_code' => '+973',
                'phone' => $phone[array_rand($phone)],
                'title_en' => $name_en[$i],
                'title_ar' => $name_ar[$i]
            ]);

            $driving_trainer->organization_users()->create([
                'user_name' => 'Driving-Trainer' . $i,
                'email' => $users[$i],
                'password' => "123456",
            ]);
        }

    }
}
