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
            'created_by' => 'system@app.com',
        ]);

        $yaban = ManufactureCountry::create([
            'name_en' => 'Japan (JAMA)',
            'name_ar' => 'اليابان',
            'active' => 1,
            'created_by' => 'system@app.com',
        ]);

        $koria = ManufactureCountry::create([
            'name_en' => 'Korea (KAMA)',
            'name_ar' => 'كوريا',
            'active' => 1,
            'created_by' => 'system@app.com',
        ]);

        $Toyota = Brand::create([
            'name_en' => 'Toyota',
            'name_ar' => 'تويوتا',
            'logo' => 'seeder/toyota-Logo.jpg',
            'active' => true,
            'manufacture_country_id' => $yaban->id, //yaban
            'created_by' => 'system@app.com',
        ]);
        $models = [
            'Corolla' => 'كورولا',
            'Granvia' => 'جرانفيا',
            'Camry' => 'كامري',
            'Yaris' => 'ياريس',
        ];
        foreach ($models as $name_en => $name_ar) {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $Toyota->id,
                'created_by' => 'system@app.com',
            ]);
        }
        /******** */
        $Ford = Brand::create([
            'name_en' => 'Ford',
            'name_ar' => 'فورد',
            'logo' => 'seeder/ford-logo.png',
            'active' => true,
            'manufacture_country_id' => $almania->id, //المانيا
            'created_by' => 'system@app.com',
        ]);
        $models = [
            'Escort' => 'إسكورت',
            'Edge' => 'ايدج',
            'Escape' => 'إسكيب',
        ];
        foreach ($models as $name_en => $name_ar) {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $Ford->id,
                'created_by' => 'system@app.com',
            ]);
        }
        /*********************** */

        $Honda = Brand::create([
            'name_en' => 'Honda',
            'name_ar' => 'هوندا',
            'logo' => 'seeder/honda-logo.jpg',
            'active' => true,
            'manufacture_country_id' => $yaban->id, //yaban
            'created_by' => 'system@app.com',
        ]);
        $models = [
            'Civic' => 'سيفيك',
            'Accord' => 'أكورد',
            'Odyssey' => 'أوديسي',
        ];

        foreach ($models as $name_en => $name_ar) {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $Honda->id,
                'created_by' => 'system@app.com',
            ]);
        }
        /*********************** */

        $Kia = Brand::create([
            'name_en' => 'Kia',
            'name_ar' => 'كيا',
            'logo' => 'seeder/kia-logo.png',
            'active' => true,
            'manufacture_country_id' => $koria->id, //كوريا الجنوبية
            'created_by' => 'system@app.com',
        ]);

        $models = [
            'Telluride' => 'تيلورايد',
            'Sportage' => 'سبورتاج',
            'Niro' => 'نيرو',
        ];

        foreach ($models as $name_en => $name_ar) {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $Kia->id,
                'created_by' => 'system@app.com',
            ]);
        }
        /*********************** */

        $Mercedes = Brand::create([
            'name_en' => 'Mercedes-Benz',
            'name_ar' => 'ميرسيدس بنز',
            'logo' => 'seeder/merceedes-logo.jpg',
            'active' => true,
            'manufacture_country_id' => $almania->id, //ألمانيا
            'created_by' => 'system@app.com',
        ]);

        $models = [
            'AMG' => 'أي ام جي',
            'CLA' => 'سي ال أي',
            'E-Class Cabriolet' => 'إي-كلاس كابريوليه',
        ];

        foreach ($models as $name_en => $name_ar) {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $Mercedes->id,
                'created_by' => 'system@app.com',
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
            'created_by' => 'system@app.com',
        ]);

        $models = [
            'Series 1' => '1 سيريز ',
            'Series Convertible' => '2 سيريز',
            'Series 3' => '3 سيريز',
        ];

        foreach ($models as $name_en => $name_ar) {
            CarModel::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'brand_id' => $BMW->id,
                'created_by' => 'system@app.com',
            ]);
        }


        CarClass::create([
            'name_en' => 'GLI',
            'name_ar' => 'GLI',
            'created_by' => 'system@app.com',
        ]);

        CarClass::create([
            'name_en' => 'XLI',
            'name_ar' => 'XLI',
            'created_by' => 'system@app.com',
        ]);

        CarClass::create([
            'name_en' => 'HYBIRD',
            'name_ar' => 'HYBIRD',
            'created_by' => 'system@app.com',
        ]);
    }
}
