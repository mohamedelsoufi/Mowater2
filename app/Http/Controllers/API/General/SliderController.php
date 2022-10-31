<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function home_sliders()
    {
        $videos = Slider::with('files')->where('type', 'video_home_slider')->get();

        $first_slider = Slider::with('files')->where('type', 'home_first_slider')->get();
        $second_slider = Slider::with('files')->where('type', 'home_second_slider')->get();
        $third_slider = Slider::with('files')->where('type', 'home_third_slider')->get();
        return responseJson(1, 'success', ['videos' => $videos, 'images' => [
            'first_slider' => $first_slider,
            'second_slider' => $second_slider,
            'third_slider' => $third_slider
        ]
        ]);
    }
}
