<?php

namespace Database\Seeders;

use App\Models\WorkTime;
use Illuminate\Database\Seeder;

class WorkTimeSeeder extends Seeder
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
                'workable_type' => 'App\Models\RentalOffice',
                'workable_id' => 1,
                'from' => '9:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sat,Sun,Mon,Tue,Wed,Thu,Fri',
            ],
            [
                'workable_type' => 'App\Models\Garage',
                'workable_id' => 1,
                'from' => '9:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sat,Sun,Mon,Tue,Wed,Thu,Fri',
            ],
            [
                'workable_type' => 'App\Models\Wench',
                'workable_id' => 1,
                'from' => '9:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sat,Sun,Mon,Tue,Wed,Thu,Fri',
            ],
            [
                'workable_type' => 'App\Models\CarShowroom',
                'workable_id' => 1,
                'from' => '9:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sat,Sun,Mon,Tue,Wed,Thu,Fri',
            ],
            [
                'workable_type' => 'App\Models\Agency',
                'workable_id' => 1,
                'from' => '9:00:00',
                'to' => '17:00:00',
                'duration' => '30',
                'days' => 'Sat,Sun,Mon,Tue,Wed,Thu,Fri',
            ],
        ];
        WorkTime::insert($data);
    }
}
