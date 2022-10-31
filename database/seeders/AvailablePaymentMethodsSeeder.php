<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvailablePaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();
        DB::table('available_payment_methods')->insert(
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => $faker->numberBetween(1, 10),
                'payment_method_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('available_payment_methods')->insert(
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => $faker->numberBetween(1, 10),
                'payment_method_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('available_payment_methods')->insert(
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => $faker->numberBetween(1, 10),
                'payment_method_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('available_payment_methods')->insert(
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => $faker->numberBetween(1, 10),
                'payment_method_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('available_payment_methods')->insert(
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => $faker->numberBetween(1, 10),
                'payment_method_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('available_payment_methods')->insert(
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => $faker->numberBetween(1, 10),
                'payment_method_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('available_payment_methods')->insert(
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => $faker->numberBetween(1, 10),
                'payment_method_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('available_payment_methods')->insert(
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => $faker->numberBetween(1, 10),
                'payment_method_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('available_payment_methods')->insert(
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => $faker->numberBetween(1, 10),
                'payment_method_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('available_payment_methods')->insert(
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => $faker->numberBetween(1, 10),
                'payment_method_id' => $faker->numberBetween(1, 10),
            ]
        );

    }
}
