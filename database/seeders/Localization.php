<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;

class Localization extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = Country::create([
            'name_en' => 'Bahrain',
            'name_ar' => 'البحرين',
        ]);
        $country->file()->create([
            'path' => 'seeder/bahrain.png',
            'type' => 'country_image'
        ]);

        $city1 = City::create([
            'name_en' => 'Northern Governorate',
            'name_ar' => 'المحافظة الشمالية',
            'latitude'=>26.148400221972118,
            'longitude'=>50.48555334553522,
            'country_id' => $country->id,
        ]);
        $areas = [
            'Sar' => 'سار',
            'El Markh' => 'المرخ',
            'El Qarya' => 'القرية',
            'Mqaba' => 'مقابة',
            'Barbar' => 'باربار',
            'Diraz' => 'الدراز',
        ];
        foreach ($areas as $name_en => $name_ar) {
            Area::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'city_id' => $city1->id,
            ]);
        }


        $city2 = City::create([
            'name_en' => 'Southern Governorate',
            'name_ar' => 'المحافظة الجنوبية',
            'latitude'=>25.98974952040471,
            'longitude'=>50.561638151629786,
            'country_id' => $country->id,
        ]);
        $areas = [
            'Safra' => 'سافرة',
            'Awali' => 'عوالي',
            'Asker' => 'عسكر',
            'Gaw' => 'جو',
            'Part of East Riffa' => 'جزء من الرفاع الشرقي',
            'Part of West Riffa' => 'جزء من الرفاع الغربي',
        ];
        foreach ($areas as $name_en => $name_ar) {
            Area::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'city_id' => $city2->id,
            ]);
        }


        $city3 = City::create([
            'name_en' => 'Central Governorate',
            'name_ar' => 'المحافظة الوسطى',
            'latitude'=>26.15894523768794,
            'longitude'=> 50.521447981128055,
            'country_id' => $country->id,
        ]);
        $areas = [
            'Aali' => 'عالي',
            'Isa Town' => 'مدينة عيسى',
            'Setra' => 'سترة',
            'Sand' => 'سند',
            'Gerdab' => 'جرداب',
            'Salmabad' => 'سلماباد',
        ];
        foreach ($areas as $name_en => $name_ar) {
            Area::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'city_id' => $city3->id,
            ]);
        }

        $city4 = City::create([
            'name_en' => 'Capital',
            'name_ar' => 'العاصمة',
            'latitude'=>26.235235494428483,
            'longitude'=>50.575601675544526,
            'country_id' => $country->id,
        ]);
        $areas = [
            'Sanabis' => 'سنابس',
            'Ras Ruman' => 'راس رمان',
            'Manama Center' => 'المنامة',
            'Karbabad' => 'كرباباد',
            'Juffair' => 'جيفير',
            'Adhari' => 'عذاري',
        ];
        foreach ($areas as $name_en => $name_ar) {
            Area::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'city_id' => $city4->id,
            ]);
        }

        $city5 = City::create([
            'name_en' => 'AL MAHREK',
            'name_ar' => 'المحرق',
            'latitude'=>26.23403984111406,
            'longitude'=> 50.54789155413608,
            'country_id' => $country->id,
        ]);
        $areas = [
            'Galali' => 'قلالي',
            'busaiteen' => 'البسيتين',
            'Arad' => 'عراد',
            'Al Haidd' => 'الحد',
        ];
        foreach ($areas as $name_en => $name_ar) {
            Area::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'city_id' => $city5->id,
            ]);
        }

    }
}
