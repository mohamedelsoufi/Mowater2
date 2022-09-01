<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Country;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class MawaterVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Admin::first();
        $brands = Brand::pluck('id')->toArray();
        $car_models = CarModel::wherein('brand_id', $brands)->pluck('id')->toArray();
        $manufacturing_year = ['2018', '2019', '2020', '2021', '2022'];
        $is_new = [0, 1];
        $traveled_distance = [25000, 30000, 100000, 150000, 200000];
        $traveled_distance_type = ['km', 'mile'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $year = ['2021', '2022', '2023', '2024', '2025'];

        $price = [1598753, 3578951, 258963, 147852, 147986325];
        $threeD = ['1.obj', '2.obj'];
        $vehicle_images = [];
        $motorcycle_images = ['1.png', '2.png', '3.png', '4.png'];
        $boats_images = ['1.jpg', '2.jpg', '3.jpg', '4.jpg'];
        $latitude = [26.272000796341498, 26.270216847142375, 26.253229632066255, 26.251697684229384];
        $longitude = [50.608592796488196, 50.660938764298095, 50.639560239345236, 50.612485490810705];
        for ($i = 1; $i <= 30; $i++) {
            array_push($vehicle_images, "seeder/v$i.jpg");
        }

        $car_classes = CarClass::pluck('id')->toArray();

//        foreach ($brands as $brand) {


            $vehicle_type = ['cars', 'trucks', 'pickups'];

            for ($i = 0; $i < 4; $i++) {
                $vehicle = $user->vehicles()->create([

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
                    'wheel_size' => array_rand(wheel_size_arr()),
                    'wheel_type' => array_rand(wheel_type_arr()),
                    'sunroof' => array_rand(sunroof_arr()),
                    'selling_by_plate' => array_rand($is_new),
                    'number_plate' => array_rand($is_new) == 1 ? '1582أ' : '',
                    'price_is_negotiable' => array_rand($is_new),
                    'location' => $latitude[$i] . ',' . $longitude[$i],
                    'additional_notes' => 'السيارة بحالة جيدة',
                    'price' => $price[array_rand($price)],
                    'availability' => 1,
                    'active' => 1,
                    'user_vehicle_status' => 'for_sale'
                ]);
            }
            for ($i = 0; $i < 4; $i++) {
                $vehicle->files()->create([
                    'path' => $vehicle_images[array_rand($vehicle_images)],
                    'type' => 'vehicle_image',
                    'color_id' => $i <= 1 ? Color::first()->id : Color::skip(1)->first()->id,
                ]);
            }
            $vehicle->files()->create([
                'path' => "seeder/traffic.pdf",
                'type' => 'traffic_pdf',
            ]);

//        }


        for ($m = 0; $m < 4; $m++) {
            $motorcycle = $user->vehicles()->create([

                'vehicle_type' => 'motorcycles',
                'brand_id' => $brands[array_rand($brands)],
                'car_model_id' => $car_models[array_rand($car_models)],
                'car_class_id' => $car_classes[array_rand($car_classes)],
                'manufacturing_year' => $manufacturing_year[array_rand($manufacturing_year)],
                'is_new' => 0,
                'traveled_distance' => $traveled_distance[array_rand($traveled_distance)],
                'traveled_distance_type' => $traveled_distance_type[array_rand($traveled_distance_type)],
                'outside_color_id' => 1,
                'inside_color_id' => 1,
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
                'status' => array_rand(status_arr()),
                'insurance' => array_rand($is_new),
                'insurance_month' => $month[array_rand($month)],
                'insurance_year' => $year[array_rand($year)],
                'coverage_type' => array_rand(coverage_type_arr()),
                'remote_start' => array_rand($is_new),
                'screen' => array_rand($is_new),
                'seat_upholstery' => array_rand(seat_upholstery_arr()),
                'wheel_size' => array_rand(wheel_size_arr()),
                'wheel_type' => array_rand(wheel_type_arr()),
                'selling_by_plate' => array_rand($is_new),
                'number_plate' => array_rand($is_new) == 1 ? '1582أ' : '',
                'price_is_negotiable' => array_rand($is_new),
                'location' => $latitude[$m] . ',' . $longitude[$m],
                'additional_notes' => 'الدراجة بحالة جيدة',
                'price' => $price[array_rand($price)],
                'availability' => 1,
                'active' => 1,
                'user_vehicle_status' => 'for_sale'
            ]);
        }
        for ($i = 0; $i < 4; $i++) {
            $motorcycle->files()->create([
                'path' => "seeder/motorcycle/" . $motorcycle_images[array_rand($motorcycle_images)],
                'type' => 'vehicle_image',
                'color_id' => $i <= 1 ? Color::first()->id : Color::skip(1)->first()->id,
            ]);
        }
        $motorcycle->files()->create([
            'path' => "seeder/traffic.pdf",
            'type' => 'traffic_pdf',
        ]);

        for ($b = 0; $b < 4; $b++) {
            $boat = $user->vehicles()->create([

                'vehicle_type' => 'boats',
                'brand_id' => $brands[array_rand($brands)],
                'car_model_id' => $car_models[array_rand($car_models)],
                'car_class_id' => $car_classes[array_rand($car_classes)],
                'manufacturing_year' => $manufacturing_year[array_rand($manufacturing_year)],
                'is_new' => 0,
                'traveled_distance' => $traveled_distance[array_rand($traveled_distance)],
                'traveled_distance_type' => 'mile',
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
                'wheel_size' => array_rand(wheel_size_arr()),
                'wheel_type' => array_rand(wheel_type_arr()),
                'sunroof' => array_rand(sunroof_arr()),
                'selling_by_plate' => array_rand($is_new),
                'number_plate' => array_rand($is_new) == 1 ? '1582أ' : '',
                'price_is_negotiable' => array_rand($is_new),
                'location' => $latitude[$b] . ',' . $longitude[$b],
                'additional_notes' => 'الدراجة بحالة جيدة',
                'price' => $price[array_rand($price)],
                'availability' => 1,
                'active' => 1,
                'user_vehicle_status' => 'for_sale'
            ]);
        }

        for ($i = 0; $i < 4; $i++) {
            $boat->files()->create([
                'path' => "seeder/boats/" . $boats_images[array_rand($boats_images)],
                'type' => 'vehicle_image',
                'color_id' => $i <= 1 ? Color::first()->id : Color::skip(1)->first()->id,
            ]);
        }
        $boat->files()->create([
            'path' => "seeder/traffic.pdf",
            'type' => 'traffic_pdf',
        ]);

    }
}
