<?php

namespace Database\Seeders;

use App\Models\Section;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        DB::table('sections')->insert(
            [
                'name_en' => 'Agencies',
                'name_ar' => 'الوكالات',
                'ref_name' => 'Agency',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Cars Showroom',
                'name_ar' => 'معارض السيارات',
                'ref_name' => 'CarShowroom',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Rental Offices',
                'name_ar' => 'مكاتب التأجير',
                'ref_name' => 'RentalOffice',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Special Numbers',
                'name_ar' => 'الأرقام المميزة',
                'ref_name' => 'SpecialNumber',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Wench',
                'name_ar' => 'السطحة',
                'ref_name' => 'Wench',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Auto Service Centers',
                'name_ar' => 'مراكز خدمات المركبات',
                'ref_name' => 'AutoServiceCenter',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        $AutoServiceCenters = Section::where('ref_name','AutoServiceCenter')->first();
        DB::table('sections')->insert(
            [
                'name_en' => 'Garages',
                'name_ar' => 'الكراجات',
                'ref_name' => 'Garage',
                'section_id' => $AutoServiceCenters->id,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Mining centers and energy providers',
                'name_ar' => 'مراكز التلغيم ومزودي الطاقة',
                'ref_name' => 'MiningCenter',
                'section_id' => $AutoServiceCenters->id,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Spare parts and scrap',
                'name_ar' => 'قطع الغيار والسكراب',
                'ref_name' => 'SparePart',
                'section_id' => $AutoServiceCenters->id,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Car wash, polishing and service',
                'name_ar' => 'مغسلة وتلميع وسرفيس السيارات',
                'ref_name' => 'CarWash',
                'section_id' => $AutoServiceCenters->id,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Tire exchange centers',
                'name_ar' => 'مراكز تبديل الإطارات',
                'ref_name' => 'TireExchangeCenter',
                'section_id' => $AutoServiceCenters->id,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Technical Inspection Centers',
                'name_ar' => 'مراكز الفحص الفني',
                'ref_name' => 'TechnicalInspectionCenter',
                'section_id' => $AutoServiceCenters->id,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Accessory Stores',
                'name_ar' => 'متاجر الإكسسوارات',
                'ref_name' => 'AccessoriesStore',
                'section_id' => $AutoServiceCenters->id,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Insurance companies',
                'name_ar' => 'شركات التأمين',
                'ref_name' => 'InsuranceCompany',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Driving instructors',
                'name_ar' => 'مدربين السياقة',
                'ref_name' => 'DrivingTrainer',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Delivery',
                'name_ar' => 'التوصيل',
                'ref_name' => 'DeliveryMan',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Gas station locations',
                'name_ar' => 'مواقع محطات الوقود',
                'ref_name' => 'FuelStation',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);

        DB::table('sections')->insert(
            [
                'name_en' => 'Traffic Clearing Office',
                'name_ar' => 'مكاتب تخليص المعاملات المرورية',
                'ref_name' => 'TrafficClearingOffice',
                'section_id' => null,
                'reservation_cost_type' => $faker->randomElement(['amount', 'percentage']),
                'reservation_cost' => 10,
            ]);
    }
}
