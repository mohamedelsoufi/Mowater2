<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::create([
            'color_code' => '#FF0000',
            'color_name' => 'Red',
            'color_name_ar' => 'أحمر',
        ]);
        Color::create([
            'color_code' => '#00FFFF',
            'color_name' => 'Cyan',
            'color_name_ar' => 'ازرق سماوي',
        ]);
        /*Color::create([
            'color_code' => '#0000FF',
            'color_name' => 'Blue',
            'color_name_ar' => 'أزرق',
        ]);
        Color::create([
            'color_code' => '#00008B',
            'color_name' => 'DarkBlue',
            'color_name_ar' => 'أزرق غامق',
        ]);
        Color::create([
            'color_code' => '#ADD8E6',
            'color_name' => 'LightBlue',
            'color_name_ar' => 'أزرق فاتح',
        ]);
        Color::create([
            'color_code' => '#800080',
            'color_name' => 'Purple',
            'color_name_ar' => 'بنفسجي',
        ]);
        Color::create([
            'color_code' => '#FFFF00',
            'color_name' => 'Yellow',
            'color_name_ar' => 'أصفر',
        ]);
        Color::create([
            'color_code' => '#00FF00',
            'color_name' => 'Lime',
            'color_name_ar' => 'ليموني',
        ]);
        Color::create([
            'color_code' => '#FF00FF',
            'color_name' => 'Magenta',
            'color_name_ar' => 'أرجواني',
        ]);
        Color::create([
            'color_code' => '#FFC0CB',
            'color_name' => 'Pink',
            'color_name_ar' => 'بامبي',
        ]);
        Color::create([
            'color_code' => '#FFFFFF',
            'color_name' => 'White',
            'color_name_ar' => 'أبيض',
        ]);
        Color::create([
            'color_code' => '#C0C0C0',
            'color_name' => 'Silver',
            'color_name_ar' => 'فضي',
        ]);
        Color::create([
            'color_code' => '#808080',
            'color_name' => 'Grey',
            'color_name_ar' => 'رصاصي',
        ]);
        Color::create([
            'color_code' => '#000000',
            'color_name' => 'Black',
            'color_name_ar' => 'أسود',
        ]);
        Color::create([
            'color_code' => '#FFA500',
            'color_name' => 'Orange',
            'color_name_ar' => 'برتقالي',
        ]);
        Color::create([
            'color_code' => '#A52A2A',
            'color_name' => 'Brown',
            'color_name_ar' => 'بني',
        ]);
        Color::create([
            'color_code' => '#800000',
            'color_name' => 'Maroon',
            'color_name_ar' => 'كستنائي',
        ]);
        Color::create([
            'color_code' => '#008000',
            'color_name' => 'Green',
            'color_name_ar' => 'أخضر',
        ]);
        Color::create([
            'color_code' => '#808000',
            'color_name' => 'Olive',
            'color_name_ar' => 'زيتوني',
        ]);
        Color::create([
            'color_code' => '#7FFD4',
            'color_name' => 'Aquamarine',
            'color_name_ar' => 'زمردي',
        ]);
        */

    }
}
