<?php

namespace Database\Seeders;

use App\Models\TrainingType;
use Illuminate\Database\Seeder;

class TrainingTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      TrainingType::create([
          'type'=>'educational',
          'category_en'=>'First time',
          'category_ar'=>'أول مره',
          'no_of_hours'=>'22'
      ]);

        TrainingType::create([
            'type'=>'educational',
            'category_en'=>'fail the first time',
            'category_ar'=>'راسب مره',
            'no_of_hours'=>'8'
        ]);

        TrainingType::create([
            'type'=>'educational',
            'category_en'=>'fail the second time',
            'category_ar'=>'راسب ثاني مرة ',
            'no_of_hours'=>'6'
        ]);

        TrainingType::create([
            'type'=>'educational',
            'category_en'=>'fail the third time',
            'category_ar'=>'راسب ثالث مرة',
            'no_of_hours'=>'6'
        ]);
        TrainingType::create([
            'type'=>'educational',
            'category_en'=>'fail the fourth time',
            'category_ar'=>'راسب reverse – 4',
            'no_of_hours'=>'4'
        ]);

        TrainingType::create([
            'type'=>'assessment',
            'category_en'=>'Evaluation',
            'category_ar'=>'تقييم',
            'no_of_hours'=>'6'
        ]);
    }
}
