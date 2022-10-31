<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorizablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        DB::table('categorizables')->insert(
            [
                'categorizable_type' => 'App\Models\Garage',
                'categorizable_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('categorizables')->insert(
            [
                'categorizable_type' => 'App\Models\Garage',
                'categorizable_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('categorizables')->insert(
            [
                'categorizable_type' => 'App\Models\Garage',
                'categorizable_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('categorizables')->insert(
            [
                'categorizable_type' => 'App\Models\Garage',
                'categorizable_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('categorizables')->insert(
            [
                'categorizable_type' => 'App\Models\Garage',
                'categorizable_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('categorizables')->insert(
            [
                'categorizable_type' => 'App\Models\Garage',
                'categorizable_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('categorizables')->insert(
            [
                'categorizable_type' => 'App\Models\Garage',
                'categorizable_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('categorizables')->insert(
            [
                'categorizable_type' => 'App\Models\Garage',
                'categorizable_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('categorizables')->insert(
            [
                'categorizable_type' => 'App\Models\Garage',
                'categorizable_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
            ]
        );

        DB::table('categorizables')->insert(
            [
                'categorizable_type' => 'App\Models\Garage',
                'categorizable_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
            ]
        );

    }
}
