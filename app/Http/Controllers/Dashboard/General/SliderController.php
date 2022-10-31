<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\Section;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('type', '=', 'section')->with('files')->get();
//        $sections = Section::all();
        return view('dashboard.general.org_sliders.index', compact('sliders'));
    }


    public function show($id)
    {
        $slider = Slider::with('files')->find($id);
        $sections = Section::all();
        return view('dashboard.general.org_sliders.show', compact('slider', 'sections'));
    }

    public function update(SliderRequest $request, $id)
    {
        $slider = Slider::with('files')->find($id);

        $deleted_files = $request->has('deleted_images') ? $request->deleted_images : [];
        $updated_files = $request->has('slider_file') ? $request->slider_file : [];

        $count_deleted = count($deleted_files);
        $counter_updated = count($updated_files);
        $count_sliders = $slider->files->count();

        $total = ($counter_updated + $count_sliders ) - $count_deleted;


        if ($total > 12) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);

        } else {
            $slider->updateImage();
            return redirect()->back()->with(['success' => __('message.updated_successfully')]);
        }

    }
}
