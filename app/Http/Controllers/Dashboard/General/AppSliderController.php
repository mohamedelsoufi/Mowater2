<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\Section;
use App\Models\Slider;
use Illuminate\Http\Request;

class AppSliderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-roles'])->only('index');
        $this->middleware(['permission:create-roles'])->only('create');
        $this->middleware(['permission:update-roles'])->only('edit');
        $this->middleware(['permission:delete-roles'])->only('delete');
    }

    public function index()
    {
        try {
            $app_sliders = Slider::where('type', '!=', 'section')->with('files')->get();
            $sections = Section::all();
            return view('admin.general.app_sliders.index', compact('app_sliders', 'sections'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function show($id)
    {
        try {
            $app_slider = Slider::with('files')->find($id);
            $sections = Section::all();
            return view('admin.general.app_sliders.show', compact('app_slider', 'sections'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $app_slider = Slider::with('files')->find($id);
            $sections = Section::all();
            return view('admin.general.app_sliders.edit', compact('app_slider', 'sections'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(SliderRequest $request, $id)
    {
        try {
            $slider = Slider::with('files')->find($id);

            $deleted_files = $request->has('deleted_images') ? $request->deleted_images : [];
            $updated_files = $request->has('slider_file') ? $request->slider_file : [];

            $count_deleted = count($deleted_files);
            $counter_updated = count($updated_files);
            $count_sliders = $slider->files->count();

            $total = ($counter_updated + $count_sliders) - $count_deleted;


            if ($total > 6) {
                return redirect()->back()->with(['error' => __('message.something_wrong')]);

            } else {
                $slider->updateSliderImage();
                return redirect()->back()->with(['success' => __('message.updated_successfully')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

}
