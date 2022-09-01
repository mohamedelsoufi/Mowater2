<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Country;
use App\Models\InsuranceCompany;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = Brand::pluck('id')->toArray();
        $car_models = CarModel::pluck('id')->toArray();
        $car_classes = CarClass::pluck('id')->toArray();
        $manufacturing_year = ['2018', '2019', '2020', '2021', '2022'];
        $is_new = [0, 1];
        $traveled_distance = [25000, 30000, 100000, 150000, 200000];
        $traveled_distance_type = ['km', 'mile'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $year = ['2021', '2022', '2023', '2024', '2025'];
        $price = [1598753, 3578951, 258963, 147852, 147986325];

        $vehicle_type = ['cars', 'trucks', 'pickups', 'cars', 'trucks', 'cars', 'trucks', 'pickups', 'cars'];

        $vehicle_images = [];
        for ($i = 1; $i <= 30; $i++) {
            array_push($vehicle_images, "seeder/v$i.jpg");
        }

        $start_date = ['2022-07-05 12:00 PM', Carbon::now(), '2022-06-27 12:00 PM', '2022-06-25 12:00 PM',
            '2022-07-05 12:00 PM', Carbon::now(), '2022-06-27 12:00 PM', '2022-06-25 12:00 PM','2022-06-25 12:00 PM'];
        $end_date = [Carbon::now()->addDays(3), Carbon::now()->addDays(3),'2022-06-30 12:00 PM',
            '2022-06-28 12:00 PM',Carbon::now()->addDays(3), Carbon::now()->addDays(3),'2022-06-30 12:00 PM',
            '2022-06-28 12:00 PM','2022-06-28 12:00 PM'];
        $serial_number = 985362;

        $insurance_companies = InsuranceCompany::all();
        foreach ($insurance_companies as $key => $insurance_company) {
            $auction = Auction::create([
                'insurance_company_id' => $insurance_company->id,
                'serial_number' => $serial_number + $key,
                'insurance_amount' => 3000,
                'min_bid' => 4000,
                'start_date' => $start_date[$key],
                'end_date' => $end_date[$key],
            ]);
            $vehicle = $auction->vehicles()->create([
                'vehicle_type' => $vehicle_type[array_rand($vehicle_type)],
                'brand_id' => $brands[array_rand($brands)],
                'car_model_id' => $car_models[array_rand($car_models)],
                'car_class_id' => $car_classes[array_rand($car_classes)],
                'manufacturing_year' => $manufacturing_year[array_rand($manufacturing_year)],
                'is_new' => 0,
                'traveled_distance' => $traveled_distance[array_rand($traveled_distance)],
                'traveled_distance_type' => $traveled_distance_type[array_rand($traveled_distance_type)],
                'outside_color_id' => 1,
                'inside_color_id' => 2,
                'in_bahrain' => array_rand($is_new),
                'country_id' => Country::first()->id,
                'guarantee' => array_rand($is_new),
                'guarantee_month' => $month[array_rand($month)],
                'guarantee_year' => $year[array_rand($year)],
                'transmission_type' => array_rand(transmission_type_arr()),
                'engine_size' => array_rand(engine_size_arr()),
                'start_with_fingerprint' => array_rand($is_new),
                'cylinder_number' => array_rand(cylinder_number_arr()),
                'fuel_type' => array_rand(fuel_type_arr()),
                'wheel_drive_system' => array_rand(wheel_drive_system_arr()),
                'specifications' => array_rand(specifications_arr()),
                'status' => array_rand(status_arr()),
                'insurance' => array_rand($is_new),
                'insurance_month' => $month[array_rand($month)],
                'insurance_year' => $year[array_rand($year)],
                'coverage_type' => array_rand(coverage_type_arr()),
                'remote_start' => array_rand($is_new),
                'screen' => array_rand($is_new),
                'seat_upholstery' => array_rand(seat_upholstery_arr()),
                'air_conditioning_system' => array_rand(air_conditioning_system_arr()),
                'windows_control' => array_rand(windows_control_arr()),
                'electric_back_door' => array_rand($is_new),
                'wheel_size' => array_rand(wheel_size_arr()),
                'wheel_type' => array_rand(wheel_type_arr()),
                'sunroof' => array_rand(sunroof_arr()),
                'selling_by_plate' => array_rand($is_new),
                'number_plate' => 'A552',
                'price_is_negotiable' => array_rand($is_new),
                'location' => '',
                'additional_notes' => '',
                'price' => $price[array_rand($price)],
                'availability' => array_rand($is_new),
                'active' => array_rand($is_new),
            ]);

            for ($i = 0; $i < 4; $i++) {
                $vehicle->files()->create([
                    'path' => $vehicle_images[array_rand($vehicle_images)],
                    'type' => 'vehicle_image',
                    'color_id' => $i <= 1 ? Color::first()->id : Color::skip(1)->first()->id,
                ]);
            }
        }
    }
}
