<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name_ar' => 'كاش',
            'name_en' => 'Cash',
            'symbol' => 'seeder/cash.png',
        ]);

        PaymentMethod::create([
            'name_ar' => 'بطاقة بنكية',
            'name_en' => 'Visa',
            'symbol' => 'seeder/visa.png',
        ]);

        PaymentMethod::create([
            'name_ar' => 'بنفت باي',
            'name_en' => 'BenefitPay',
            'symbol' => 'seeder/benefitPay.png',
        ]);

        PaymentMethod::create([
            'name_ar' => 'سديم',
            'name_en' => 'Sadeem',
            'symbol' => 'seeder/sadeem.png',
        ]);
        PaymentMethod::create([
            'name_ar' => 'أقساط',
            'name_en' => 'installments',
            'symbol' => 'seeder/installments.jpg',
        ]);
    }
}
