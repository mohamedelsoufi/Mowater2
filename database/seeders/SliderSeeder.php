<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $videos = ['1.mp4', '2.mp4', '3.mp4', '4.mp4', '5.mp4', '6.mp4'];
        $first = ['1.jpg', '2.png', '3.png', '4.png', '5.jpg', '6.png'];
        $second = ['7.jpg', '8.png', '9.jpg', '10.jpg', '11.jpg', '12.jpg'];
        $third = ['13.jpg', '14.jpg', '15.png', '16.jpg', '17.jpg', '18.jpg'];
        $video_home_slider = Slider::create([
            'section_id' => null,
            'type' => 'video_home_slider'
        ]);
        for ($v = 0; $v < 6; $v++) {
            $video_home_slider->files()->create([
                'path' => "seeder/sliders/home_videos/" . $videos[$v],
                'type' => 'video_home_slider',
                'color_id' => null,
            ]);
        }

        $home_first_slider = Slider::create([
            'section_id' => null,
            'type' => 'home_first_slider'
        ]);
        for ($v = 0; $v < 6; $v++) {
            $home_first_slider->files()->create([
                'path' => "seeder/sliders/first/" . $first[$v],
                'type' => 'home_first_slider',
                'color_id' => null,
            ]);
        }

        $home_second_slider = Slider::create([
            'section_id' => null,
            'type' => 'home_second_slider'
        ]);
        for ($v = 0; $v < 6; $v++) {
            $home_second_slider->files()->create([
                'path' => "seeder/sliders/second/" . $second[$v],
                'type' => 'home_second_slider',
                'color_id' => null,
            ]);
        }

        $home_third_slider = Slider::create([
            'section_id' => null,
            'type' => 'home_third_slider'
        ]);

        for ($v = 0; $v < 6; $v++) {
            $home_third_slider->files()->create([
                'path' => "seeder/sliders/third/" . $third[$v],
                'type' => 'home_third_slider',
                'color_id' => null,
            ]);
        }

        $section_slider = ['1.mp4', '2.png', '3.mp4', '4.jpg', '5.mp4', '6.jpg', '7.mp4', '8.jpg', '9.mp4', '10.png', '11.mp4', '12.jpg'];
        $section_id = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
        for ($s = 0; $s < 17; $s++) {
            $section = Slider::create([
                'section_id' => $section_id[$s],
                'type' => 'section'
            ]);
            for ($v = 0; $v < 12; $v++) {
                $section->files()->create([
                    'path' => "seeder/sliders/sections/" . $section_slider[$v],
                    'type' => 'section',
                    'color_id' => null,
                ]);
            }
        }

        $traffic = Slider::create([
            'section_id' => Section::where('ref_name', 'TrafficClearingOffice')->first()->id,
            'type' => 'section'
        ]);

        $traffic_slider = ['1.png', '7.mp4', '2.png', '8.mp4', '3.jpeg', '9.mp4', '4.jpg', '10.mp4', '5.jpg', '11.mp4', '6.jpg', '12.mp4'];

        for ($v = 0; $v < 12; $v++) {
            $traffic->files()->create([
                'path' => "seeder/sliders/traffic/" . $traffic_slider[$v],
                'type' => 'section',
                'color_id' => null,
            ]);
        }
    }
}
