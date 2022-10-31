<?php

namespace Database\Seeders;

use App\Models\TrafficClearingService;
use Illuminate\Database\Seeder;

class TrafficClearingServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service_en = ['Vehicle inspection', 'Pay fines', 'Vehicle registration or renewal',
            'Vehicle insurance', 'Transfer of vehicle ownership', 'Changing the plates'];
        $service_ar = ['فحص المركبة', 'دفع المخالفات', 'تسجيل أو تجديد المركبة', 'تأمين المركبة', 'نقل ملكية المركبة', 'تغيير اللوحات'];

        for ($i = 0; $i < count($service_en); $i++) {
            TrafficClearingService::create([
                'name_en' => $service_en[$i],
                'name_ar' => $service_ar[$i]
            ]);
        }
    }
}
