<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DayOffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'model_type' => 'App\Models\Agency',
                'model_id' => 1,
                'date' => Carbon::now()->format('Y-m-d'),
                'from' => '9:00:00',
                'to' => '17:00:00',
            ],
            [
                'model_type' => 'App\Models\CarShowroom',
                'model_id' => 1,
                'date' => Carbon::now()->format('Y-m-d'),
                'from' => '9:00:00',
                'to' => '17:00:00',
            ],
            [
                'model_type' => 'App\Models\RentalOffice',
                'model_id' => 1,
                'date' => Carbon::now()->format('Y-m-d'),
                'from' => '9:00:00',
                'to' => '17:00:00',
            ],
            [
                'model_type' => 'App\Models\Garage',
                'model_id' => 1,
                'date' => Carbon::now()->format('Y-m-d'),
                'from' => '9:00:00',
                'to' => '17:00:00',
            ],
            [
                'model_type' => 'App\Models\Wench',
                'model_id' => 1,
                'date' => Carbon::now()->format('Y-m-d'),
                'from' => '9:00:00',
                'to' => '17:00:00',
            ],

        ];
        DB::table('day_offs')->insert($data);
    }
}
