<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SectionRequest;
use App\Models\DrivingTrainer;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-sections'])->only('index');
        $this->middleware(['permission:update-sections'])->only('edit');
    }

    public function index()
    {
        try {
            $sections = Section::where('section_id', null)->get();
            return view('admin.general.sections.index', compact('sections'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function subSection($id)
    {
        try {
            $sub_sections = Section::where('section_id', '!=', null)->where('section_id',$id)->get();
            return view('admin.general.sections.sub_section', compact('sub_sections'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $section = Section::find($id);
            return view('admin.general.sections.show', compact('section'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $section = Section::find($id);
            $main_sections = Section::where('section_id', null)->get();
            return view('admin.general.sections.edit', compact('section'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(SectionRequest $request, $id)
    {
        try {
            $section = Section::find($id);
            if ($section['ref_name'] == "DrivingTrainer") {
                foreach (DrivingTrainer::all() as $trainer) {
                    $trainer->update(['hour_price' => $request->reservation_cost]);
                }
            }
            $section->update($request->except(['_token', 'ref_name']));

            $section->updateImage();

            return redirect()->route('sections.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
