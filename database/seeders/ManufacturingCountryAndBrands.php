<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\CarClass;
use App\Models\ManufactureCountry;
use Illuminate\Database\Seeder;

class ManufacturingCountryAndBrands extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $almania = ManufactureCountry::create([
                    'name_en' => 'Germany',
                    'name_ar' => 'ألمانيا',
                    'active' => 1,
                ]);

        $yaban =  ManufactureCountry::create([
                    'name_en' => 'Japan (JAMA)',
                    'name_ar' => 'اليابان',
                    'active' => 1,
                ]);

        $koria = ManufactureCountry::create([
                    'name_en' => 'Korea (KAMA)',
                    'name_ar' => 'كوريا',
                    'active' => 1,
                ]);

        $Toyota = Brand::create([
            'name_en' => 'Toyota',
            'name_ar' => 'تويوتا',
            'logo' => 'seeder/toyota-Logo.jpg',
            'active' => true,
            'manufacture_country_id' => $yaban->id, //yaban
        ]);
        $models = [
            'Corolla' => 'كورولا',
            'Granvia' => 'جرانفيا',
            'Camry' => 'كامري',
            'Yaris' => 'ياريس',
        ];
        foreach($models as $name_en => $name_ar)
        {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $Toyota->id,
            ]);
        }
        /******** */
        $Ford = Brand::create([
            'name_en' => 'Ford',
            'name_ar' => 'فورد',
            'logo' => 'seeder/ford-logo.png',
            'active' => true,
            'manufacture_country_id' =>  $almania->id , //المانيا
        ]);
        $models = [
            'Escort' => 'إسكورت',
            'Edge' => 'ايدج',
            'Escape' => 'إسكيب',
        ];
        foreach($models as $name_en => $name_ar)
        {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $Ford->id,
            ]);
        }
         /*********************** */

        $Honda = Brand::create([
            'name_en' => 'Honda',
            'name_ar' => 'هوندا',
            'logo' => 'seeder/honda-logo.jpg',
            'active' => true,
            'manufacture_country_id' => $yaban->id, //yaban
        ]);
        $models = [
            'Civic' => 'سيفيك',
            'Accord' => 'أكورد',
            'Odyssey' => 'أوديسي',
        ];

        foreach($models as $name_en => $name_ar)
        {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $Honda->id,
            ]);
        }
        /*********************** */

        $Kia = Brand::create([
            'name_en' => 'Kia',
            'name_ar' => 'كيا',
            'logo' => 'seeder/kia-logo.png',
            'active' => true,
            'manufacture_country_id' => $koria->id, //كوريا الجنوبية
        ]);

        $models = [
            'Telluride' => 'تيلورايد',
            'Sportage' => 'سبورتاج',
            'Niro' => 'نيرو',
        ];

        foreach($models as $name_en => $name_ar)
        {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $Kia->id,
            ]);
        }
        /*********************** */

        $Mercedes = Brand::create([
            'name_en' => 'Mercedes-Benz',
            'name_ar' => 'ميرسيدس بنز',
            'logo' => 'seeder/merceedes-logo.jpg',
            'active' => true,
            'manufacture_country_id' => $almania->id, //ألمانيا
        ]);

        $models = [
            'AMG' => 'أي ام جي',
            'CLA' => 'سي ال أي',
            'E-Class Cabriolet' => 'إي-كلاس كابريوليه',
        ];

        foreach($models as $name_en => $name_ar)
        {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $Mercedes->id,
            ]);
        }

        /*********************** */

        /*$Suzuki = Brand::create([
            'name_en' => 'Suzuki',
            'name_ar' => 'سوزوكي',
            'active' => true,
            'manufacture_country_id' => $yaban->id, //يابان
        ]);

        $Volkswagen = Brand::create([
            'name_en' => 'Volkswagen',
            'name_ar' => 'فولكس فاجن',
            'active' => true,
            'manufacture_country_id' => $almania->id, //المانيا
        ]);*/

        $BMW = Brand::create([
            'name_en' => 'BMW',
            'name_ar' => 'بى إم دبليو',
            'logo' => 'seeder/bmw-logo.png',
            'active' => true,
            'manufacture_country_id' => $almania->id, // المانيا
        ]);

        $models = [
            'Series 1' => '1 سيريز ',
            'Series Convertible' => '2 سيريز',
            'Series 3' => '3 سيريز',
        ];

        foreach($models as $name_en => $name_ar)
        {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $BMW->id,
            ]);
        }


        CarClass::create([
            'name_en' => 'GLI',
            'name_ar' => 'GLI',
        ]);

        CarClass::create([
            'name_en' => 'XLI',
            'name_ar' => 'XLI',
        ]);

        CarClass::create([
            'name_en' => 'HYBIRD',
            'name_ar' => 'HYBIRD',
        ]);
    }
}
