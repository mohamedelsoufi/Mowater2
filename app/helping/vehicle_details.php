<?php


function body_shape()
{
    $body_shapes = array_keys(body_shape_arr());

    return implode(',', $body_shapes);
}

function body_shape_arr()
{
    return [
        'sedan' => __('vehicle.sedan'),
        'hatchback' => __('vehicle.hatchback'),
//        'motorcycles' => __('vehicle.motorcycles'),
//        'cruisers' => __('vehicle.cruisers'),
//        'pickups' => __('vehicle.pickups'),
//        'trucks' => __('vehicle.trucks'),
    ];
}

function fuel_type()
{
    $fuel_types = array_keys(fuel_type_arr());

    return implode(',', $fuel_types);
}

function fuel_type_arr()
{
    return [
        'petrol' => __('vehicle.petrol'),
        'diesel' => __('vehicle.diesel'),
        'hybrid' => __('vehicle.hybrid'),
        'electrician' => __('vehicle.electrician'),
    ];
}

function seat_upholstery()
{
    $seat_upholstery = array_keys(seat_upholstery_arr());

    return implode(',', $seat_upholstery);
}

function seat_upholstery_arr()
{
    return [
        'fabric' => __('vehicle.fabric'),
        'leather' => __('vehicle.leather'),
        'sporty' => __('vehicle.sporty'),
    ];
}

function electric_windows()
{
    $electric_windows = array_keys(electric_windows_arr());

    return implode(',', $electric_windows);
}

function electric_windows_arr()
{
    return [
        'front' => __('vehicle.front'),
        'back' => __('vehicle.back'),
        'front_plus_back' => __('vehicle.front_plus_back')
    ];
}

function sunroof()
{
    $sunroof = array_keys(sunroof_arr());

    return implode(',', $sunroof);
}

function sunroof_arr()
{
    return [
        'panoramic_sunroof' => __('vehicle.panoramic_sunroof'),
        'exposure' => __('vehicle.exposure'),
        'none' => __('vehicle.none')
    ];
}

function car_gear_shift_knob()
{
    $car_gear_shift_knob = array_keys(car_gear_shift_knob_arr());
    return implode(',', $car_gear_shift_knob);
}

function car_gear_shift_knob_arr()
{
    return [
        'Manual' => __('vehicle.Manual'),
        'Automatic' => __('vehicle.Automatic')
    ];
}

function front_lighting()
{
    $front_lighting = array_keys(front_lighting_arr());
    return implode(',', $front_lighting);
}

function front_lighting_arr()
{
    return [
        'high_level' => __('vehicle.high_level'),
        'low_level' => __('vehicle.low_level')
    ];
}

function transparent_coating()
{
    $transparent_coating = array_keys(transparent_coating_arr());
    return implode(',', $transparent_coating);
}

function transparent_coating_arr()
{
    return [
        'Full' => __('vehicle.Full'),
        'Rear' => __('vehicle.Rear'),
        'front' => __('vehicle.front'),
        'none' => __('vehicle.none')
    ];
}

function back_lights()
{
    $back_lights = array_keys(back_lights_arr());
    return implode(',', $back_lights);
}

function back_lights_arr()
{
    return [
        'high_level' => __('vehicle.high_level'),
        'low_level' => __('vehicle.low_level')
    ];
}

function roof()
{
    $roof = array_keys(roof_arr());
    return implode(',', $roof);
}

function roof_arr()
{
    return [
        'sun_roof' => __('vehicle.sun_roof'),
        'moon_roof' => __('vehicle.moon_roof'),
        'none' => __('vehicle.none')
    ];
}

function injection_type()
{
    $injection_type = array_keys(injection_type_arr());
    return implode(',', $injection_type);
}

function injection_type_arr()
{
    return [
        'Single_point_fuel_injection_system_or_throttle_injection' => __('vehicle.Single_point_fuel_injection_system_or_throttle_injection'),
        'Multi_port_injection_system' => __('vehicle.Multi_port_injection_system'),
        'Sequential_fuel_injection' => __('vehicle.Sequential_fuel_injection'),
        'direct_injection' => __('vehicle.direct_injection')
    ];
}

function wench_type()
{
    $wench_type = array_keys(wench_type_arr());
    return implode(',', $wench_type);
}

function wench_type_arr()
{
    return [
        'rooftop_vehicle' => __('vehicle.rooftop_vehicle'),
        'wench' => __('vehicle.wench')
    ];
}

function user_vehicle_status()
{
    $user_vehicle_status = ['for_sale', 'not_for_sale', 'reverse'];
    return implode(',', $user_vehicle_status);
}

function vehicle_type()
{
    $vehicle_type = array_keys(vehicle_type_arr());
    return implode(',', $vehicle_type);
}

function vehicle_type_arr()
{
    return [
        'cars' => __('vehicle.cars'),
        'motorcycles' => __('vehicle.motorcycles'),
        'trucks' => __('vehicle.trucks'),
        'heavy_equipment' => __('vehicle.heavy_equipment'),
        'pickups' => __('vehicle.pickups'),
        'boats' => __('vehicle.boats')
    ];
}

function traveled_distance_type()
{
    $traveled_distance_type = ['Km', 'Mile'];
    return implode(',', $traveled_distance_type);
}

function car_status()
{
    $car_status = ['excellent', 'very_good', 'good'];
    return implode(',', $car_status);
}

function transmission_type()
{
    $transmission_type = array_keys(transmission_type_arr());
    return implode(',', $transmission_type);
}

function transmission_type_arr()
{
    return [
        'Manual' => __('vehicle.Manual'),
        'Automatic' => __('vehicle.Automatic')
    ];
}

function engine_size()
{
    $engine_size = array_keys(engine_size_arr());
    return implode(',', $engine_size);
}

function engine_size_arr()
{
    return [
        '1100_CC' => __('vehicle.1100_CC'),
        '1200_CC' => __('vehicle.1200_CC'),
        '1300_CC' => __('vehicle.1300_CC'),
        '1400_CC' => __('vehicle.1400_CC'),
        '1500_CC' => __('vehicle.1500_CC'),
        '1600_CC' => __('vehicle.1600_CC'),
        '1700_CC' => __('vehicle.1700_CC'),
        '1800_CC' => __('vehicle.1800_CC'),
        '1900_CC' => __('vehicle.1900_CC'),
        '2000_CC' => __('vehicle.2000_CC'),
        '2100_CC' => __('vehicle.2100_CC'),
        '2200_CC' => __('vehicle.2200_CC'),
        '2300_CC' => __('vehicle.2300_CC'),
        '2400_CC' => __('vehicle.2400_CC'),
        '2500_CC' => __('vehicle.2500_CC'),
        '2600_CC' => __('vehicle.2600_CC'),
        '2700_CC' => __('vehicle.2700_CC'),
        '2800_CC' => __('vehicle.2800_CC'),
        '2900_CC' => __('vehicle.2900_CC'),
        '3000_CC' => __('vehicle.3000_CC'),
    ];
}

function cylinder_number()
{
    $cylinder_number = array_keys(cylinder_number_arr());
    return implode(',', $cylinder_number);
}

function cylinder_number_arr()
{
    return [
        '3' => '3',
        '4' => '4',
        '6' => '6',
        '8' => '8',
        '10' => '10',
        '12' => '12',
    ];
}

function wheel_drive_system()
{
    $wheel_drive_system = array_keys(wheel_drive_system_arr());
    return implode(',', $wheel_drive_system);
}

function wheel_drive_system_arr()
{
    return [
        'front_fwd' => __('vehicle.front_fwd'),
        'back_fwd' => __('vehicle.back_fwd'),
        'four_wheel_drive' => __('vehicle.four_wheel_drive'),
        'permanent_four-wheel_drive' => __('vehicle.permanent_four-wheel_drive'),
    ];
}


function specifications()
{
    $specifications = array_keys(specifications_arr());
    return implode(',', $specifications);
}

function specifications_arr()
{
    return [
        'full_option' => __('vehicle.full_option'),
        'mid_option' => __('vehicle.mid_option'),
        'low_option' => __('vehicle.low_option'),
    ];
}

function air_conditioning_system()
{
    $air_conditioning_system = array_keys(air_conditioning_system_arr());
    return implode(',', $air_conditioning_system);
}

function air_conditioning_system_arr()
{
    return [
        'front' => __('vehicle.front'),
        'front_plus_back' => __('vehicle.front_plus_back'),
    ];
}

function windows_control()
{
    $windows_control = array_keys(windows_control_arr());
    return implode(',', $windows_control);
}

function windows_control_arr()
{
    return [
        'Manual' => __('vehicle.Manual'),
        'Automatic' => __('vehicle.Automatic')
    ];
}

function wheel_size()
{
    $wheel_size = array_keys(wheel_size_arr());
    return implode(',', $wheel_size);
}

function wheel_size_arr()
{
    return [

        '185/70/13' => __('vehicle.185/70/13'),
        '175/70/13' => __('vehicle.175/70/13'),
        '165/70/13' => __('vehicle.165/70/13'),
        '165/80/13' => __('vehicle.165/80/13'),
        '155/70/13' => __('vehicle.155/70/13'),
        '195/60/14' => __('vehicle.195/60/14'),
        '195/65/14' => __('vehicle.195/65/14'),
        '195/70/14' => __('vehicle.195/70/14'),
        '185/55/14' => __('vehicle.185/55/14'),
        '185/60/14' => __('vehicle.185/60/14'),
        '185/65/14' => __('vehicle.185/65/14'),
        '185/70/14' => __('vehicle.185/70/14'),
        '185/80/14' => __('vehicle.185/80/14'),
        '175/65/14' => __('vehicle.175/65/14'),
        '175/70/14' => __('vehicle.175/70/14'),
        '165/65/14' => __('vehicle.165/65/14'),
        '165/70/14' => __('vehicle.165/70/14'),
        '351/25/15' => __('vehicle.351/25/15'),
        '32/12.5/15' => __('vehicle.32/12.5/15'),
        '309/50/15' => __('vehicle.309/50/15'),
        '255/70/15' => __('vehicle.255/70/15'),
        '235/75/15' => __('vehicle.235/75/15'),
        '225/75/15' => __('vehicle.225/75/15'),
        '215/65/15' => __('vehicle.215/65/15'),
        '215/70/15' => __('vehicle.215/70/15'),
        '215/75/15' => __('vehicle.215/75/15'),
        '205/60/15' => __('vehicle.205/60/15'),
        '205/65/15' => __('vehicle.205/65/15'),
        '205/70/15' => __('vehicle.205/70/15'),
        '195/50/15' => __('vehicle.195/50/15'),
        '195/55/15' => __('vehicle.195/55/15'),
        '195/60/15' => __('vehicle.195/60/15'),
        '195/65/15' => __('vehicle.195/65/15'),
        '195/80/15' => __('vehicle.195/80/15'),
        '185/55/15' => __('vehicle.185/55/15'),
        '185/60/15' => __('vehicle.185/60/15'),
        '185/65/15' => __('vehicle.185/65/15'),
        '175/65/15' => __('vehicle.175/65/15'),
        '33/12.5/15' => __('vehicle.33/12.5/15'),
        '33/12.50/15' => __('vehicle.33/12.50/15'),
        '125/35/17' => __('vehicle.125/35/17'),
        '32/11.5/15' => __('vehicle.32/11.5/15'),
        '321/15/15' => __('vehicle.321/15/15'),
        '105/31/15' => __('vehicle.105/31/15'),
        '33/10.5/15' => __('vehicle.33/10.5/15'),
        '305/70/16' => __('vehicle.305/70/16'),
        '275/70/16' => __('vehicle.275/70/16'),
        '265/70/16' => __('vehicle.265/70/16'),
        '265/75/16' => __('vehicle.265/75/16'),
        '255/65/16' => __('vehicle.255/65/16'),
        '255/70/16' => __('vehicle.255/70/16'),
        '245/70/16' => __('vehicle.245/70/16'),
        '245/75/16' => __('vehicle.245/75/16'),
        '235/60/16' => __('vehicle.235/60/16'),
        '235/70/16' => __('vehicle.235/70/16'),
        '235/85/16' => __('vehicle.235/85/16'),
        '225/50/16' => __('vehicle.225/50/16'),
        '225/55/16' => __('vehicle.225/55/16'),
        '225/60/16' => __('vehicle.225/60/16'),
        '225/70/16' => __('vehicle.225/70/16'),
        '225/75/16' => __('vehicle.225/75/16'),
        '215/45/16' => __('vehicle.215/45/16'),
        '215/55/16' => __('vehicle.215/55/16'),
        '215/60/16' => __('vehicle.215/60/16'),
        '215/65/16' => __('vehicle.215/65/16'),
        '215/70/16' => __('vehicle.215/70/16'),
        '205/45/16' => __('vehicle.205/45/16'),
        '205/50/16' => __('vehicle.205/50/16'),
        '205/55/16' => __('vehicle.205/55/16'),
        '205/60/16' => __('vehicle.205/60/16'),
        '205/80/16' => __('vehicle.205/80/16'),
        '195/45/16' => __('vehicle.195/45/16'),
        '195/50/16' => __('vehicle.195/50/16'),
        '195/55/16' => __('vehicle.195/55/16'),
        '195/60/16' => __('vehicle.195/60/16'),
        '185/55/16' => __('vehicle.185/55/16'),
        '315/70/17' => __('vehicle.315/70/17'),
        '305/65/17' => __('vehicle.305/65/17'),
        '285/65/17' => __('vehicle.285/65/17'),
        '285/70/17' => __('vehicle.285/70/17'),
        '275/40/17' => __('vehicle.275/40/17'),
        '275/55/17' => __('vehicle.275/55/17'),
        '275/65/17' => __('vehicle.275/65/17'),
        '275/70/17' => __('vehicle.275/70/17'),
        '265/65/17' => __('vehicle.265/65/17'),
        '265/70/17' => __('vehicle.265/70/17'),
        '255/40/17' => __('vehicle.255/40/17'),
        '255/60/17' => __('vehicle.255/60/17'),
        '245/40/17' => __('vehicle.245/40/17'),
        '245/45/17' => __('vehicle.245/45/17'),
        '245/55/17' => __('vehicle.245/55/17'),
        '245/65/17' => __('vehicle.245/65/17'),
        '245/70/17' => __('vehicle.245/70/17'),
        '245/75/17' => __('vehicle.245/75/17'),
        '235/40/17' => __('vehicle.235/40/17'),
        '235/45/17' => __('vehicle.235/45/17'),
        '235/50/17' => __('vehicle.235/50/1'),
        '235/55/17' => __('vehicle.235/55/17'),
        '235/60/17' => __('vehicle.235/60/17'),
        '235/65/17' => __('vehicle.235/65/17'),
        '225/45/17' => __('vehicle.225/45/17'),
        '225/50/17' => __('vehicle.225/50/17'),
        '225/55/17' => __('vehicle.225/55/17'),
        '225/60/17' => __('vehicle.225/60/17'),
        '225/65/17' => __('vehicle.225/65/17'),
        '225/70/17' => __('vehicle.225/70/17'),
        '215/40/17' => __('vehicle.215/40/17'),
        '215/45/17' => __('vehicle.215/45/17'),
        '215/50/17' => __('vehicle.215/50/17'),
        '215/55/17' => __('vehicle.215/55/17'),
        '215/60/17' => __('vehicle.215/60/17'),
        '215/65/17' => __('vehicle.215/65/17'),
        '205/40/17' => __('vehicle.205/40/17'),
        '205/45/17' => __('vehicle.205/45/17'),
        '205/50/17' => __('vehicle.205/50/17'),
        '205/55/17' => __('vehicle.205/55/17'),
        '39/13.5/17' => __('vehicle.39/13.5/17'),
        '35/12.5/17' => __('vehicle.35/12.5/17'),
        '37/12.5/17' => __('vehicle.37/12.5/17'),
        '295/35/18' => __('vehicle.295/35/18'),
        '285/30/18' => __('vehicle.285/30/18'),
        '285/35/18' => __('vehicle.285/35/18'),
        '285/60/18' => __('vehicle.285/60/18'),
        '275/35/18' => __('vehicle.275/35/18'),
        '275/40/18' => __('vehicle.275/40/18'),
        '275/45/18' => __('vehicle.275/45/18'),
        '275/60/18' => __('vehicle.275/60/18'),
        '275/65/18' => __('vehicle.275/65/18'),
        '275/70/18' => __('vehicle.275/70/18'),
        '265/35/15' => __('vehicle.265/35/15'),
        '265/35/18' => __('vehicle.265/35/18'),
        '265/40/18' => __('vehicle.265/40/18'),
        '265/60/18' => __('vehicle.265/60/18'),
        '265/70/18' => __('vehicle.265/70/18'),
        '235/35/18' => __('vehicle.235/35/18'),
        '255/35/18' => __('vehicle.255/35/18'),
        '255/40/18' => __('vehicle.255/40/18'),
        '255/45/18' => __('vehicle.255/45/18'),
        '255/55/18' => __('vehicle.255/55/18'),
        '255/60/18' => __('vehicle.255/60/18'),
        '245/35/18' => __('vehicle.245/35/18'),
        '245/40/18' => __('vehicle.245/40/18'),
        '245/45/18' => __('vehicle.245/45/18'),
        '245/50/18' => __('vehicle.245/50/18'),
        '245/60/18' => __('vehicle.245/60/18'),
        '235/40/18' => __('vehicle.235/40/18'),
        '235/45/18' => __('vehicle.235/45/18'),
        '235/50/18' => __('vehicle.235/50/18'),
        '235/55/18' => __('vehicle.235/55/18'),
        '235/60/18' => __('vehicle.235/60/18'),
        '235/65/18' => __('vehicle.235/65/18'),
        '215/60/16_18' => __('vehicle.215/60/16_18'),
        '225/40/18' => __('vehicle.225/40/18'),
        '225/45/18' => __('vehicle.225/45/18'),
        '255/50/18' => __('vehicle.255/50/18'),
        '225/55/18' => __('vehicle.225/55/18'),
        '225/60/18' => __('vehicle.225/60/18'),
        '215/40/18' => __('vehicle.215/40/18'),
        '215/45/18' => __('vehicle.215/45/18'),
        '215/55/18' => __('vehicle.215/55/18'),
        '325/30/19' => __('vehicle.325/30/19'),
        '305/30/19' => __('vehicle.305/30/19'),
        '295/30/19' => __('vehicle.295/30/19'),
        '285/35/19' => __('vehicle.285/35/19'),
        '285/40/19' => __('vehicle.285/40/19'),
        '285/45/19' => __('vehicle.285/45/19'),
        '275/30/19' => __('vehicle.275/30/19'),
        '275/35/19' => __('vehicle.275/35/19'),
        '275/40/19' => __('vehicle.275/40/19'),
        '275/45/17' => __('vehicle.275/45/17'),
        '275/45/19' => __('vehicle.275/45/19'),
        '275/50/19' => __('vehicle.275/50/19'),
        '275/55/19' => __('vehicle.275/55/19'),
        '265/30/19' => __('vehicle.265/30/19'),
        '265/35/19' => __('vehicle.265/35/19'),
        '265/50/19' => __('vehicle.265/50/19'),
        '255/35/19' => __('vehicle.255/35/19'),
        '255/40/19' => __('vehicle.255/40/19'),
        '255/45/19' => __('vehicle.255/45/19'),
        '255/50/19' => __('vehicle.255/50/19'),
        '255/55/19' => __('vehicle.255/55/19'),
        '245/35/19' => __('vehicle.245/35/19'),
        '245/40/19' => __('vehicle.245/40/19'),
        '245/45/19' => __('vehicle.245/45/19'),
        '235/35/19' => __('vehicle.235/35/19'),
        '235/50/19' => __('vehicle.235/50/19'),
        '235/55/19' => __('vehicle.235/55/19'),
        '225/35/19' => __('vehicle.225/35/19'),
        '225/40/19' => __('vehicle.225/40/19'),
        '225/45/19' => __('vehicle.225/45/19'),
        '335/25/20' => __('vehicle.335/25/20'),
        '315/35/20' => __('vehicle.315/35/20'),
        '305/50/20' => __('vehicle.305/50/20'),
        '295/30/20' => __('vehicle.295/30/20'),
        '295/35/20' => __('vehicle.295/35/20'),
        '295/40/20' => __('vehicle.295/40/20'),
        '285/30/20' => __('vehicle.285/30/20'),
        '285/50/20' => __('vehicle.285/50/20'),
        '285/65/20' => __('vehicle.285/65/20'),
        '275/35/20' => __('vehicle.275/35/20'),
        '275/40/20' => __('vehicle.275/40/20'),
        '275/45/20' => __('vehicle.275/45/20'),
        '275/50/20' => __('vehicle.275/50/20'),
        '275/60/20' => __('vehicle.275/60/20'),
        '265/50/20' => __('vehicle.265/50/20'),
        '255/30/20' => __('vehicle.255/30/20'),
        '255/35/20' => __('vehicle.255/35/20'),
        '255/40/20' => __('vehicle.255/40/20'),
        '255/45/20' => __('vehicle.255/45/20'),
        '255/50/20' => __('vehicle.255/50/20'),
        '255/55/20' => __('vehicle.255/55/20'),
        '245/35/20' => __('vehicle.245/35/20'),
        '245/40/20' => __('vehicle.245/40/20'),
        '245/45/20' => __('vehicle.245/45/20'),
        '235/35/20' => __('vehicle.235/35/20'),
        '295/35/21' => __('vehicle.295/35/21'),
        '285/30/21' => __('vehicle.285/30/21'),
        '275/45/21' => __('vehicle.275/45/21'),
    ];
}

function wheel_type()
{
    $wheel_type = array_keys(wheel_type_arr());
    return implode(',', $wheel_type);
}

function wheel_type_arr()
{
    return [
        'aluminum' => __('vehicle.aluminum'),
        'kibat' => __('vehicle.kibat')
    ];
}

function ghamara_count()
{
    $ghamara_count = array_keys(ghamara_count_arr());
    return implode(',', $ghamara_count);
}

function ghamara_count_arr()
{
    return [
        'one_ghamara' => __('vehicle.one_ghamara'),
        'half_ghamara' => __('vehicle.half_ghamara'),
        'two_ghamaras' => __('vehicle.two_ghamaras'),
    ];
}


function status()
{
    $status = array_keys(status_arr());
    return implode(',', $status);
}

function status_arr()
{
    return [
        'agency_status' => __('vehicle.agency_status'),
        'excellent' => __('vehicle.excellent'),
        'good' => __('vehicle.good'),
        'scrap' => __('vehicle.scrap'),
    ];
}

function coverage_type()
{
    $coverage_type = array_keys(coverage_type_arr());
    return implode(',', $coverage_type);
}

function coverage_type_arr()
{
    return [
        'full_insurance' => __('vehicle.full_insurance'),
        'third_party' => __('vehicle.third_party'),
    ];
}

function rental_car_types()
{
    $rental_car_types = array_keys(rental_car_types_arr());
    return implode(',', $rental_car_types);
}

function rental_car_types_arr()
{
    return [
        'economy_cars' => __('vehicle.economy_cars'),
        'sedan' => __('vehicle.sedan'),
        'sports_cars' => __('vehicle.sports_cars'),
        'rental_four_wheel_drive' => __('vehicle.rental_four_wheel_drive'),
        'luxury' => __('vehicle.luxury'),
        'pick_up' => __('vehicle.pick_up'),
        'van' => __('vehicle.van'),
        'hatchback' => __('vehicle.hatchback'),
    ];
}

