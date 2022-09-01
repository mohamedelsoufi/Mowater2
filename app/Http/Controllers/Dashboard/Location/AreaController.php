<?php

namespace App\Http\Controllers\Dashboard\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AreaRequest;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-areas'])->only('index');
        $this->middleware(['permission:create-areas'])->only('create');
        $this->middleware(['permission:update-areas'])->only('edit');
        $this->middleware(['permission:delete-areas'])->only('delete');
    }

    public function index()
    {
        try {
            $areas = Area::latest('id')->get();
            $cities = City::latest('id')->get();
            return view('admin.location.areas.index', compact('areas', 'cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error', __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $area = Area::find($id);
            return view('admin.location.areas.show', compact('area'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error', __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $cities = City::latest('id')->get();
            return view('admin.location.areas.create', compact('cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error', __('message.something_wrong')]);
        }
    }

    public function store(AreaRequest $request)
    {
        try {
            $area = Area::create($request->except(['_token']));
            return redirect()->route('areas.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error', __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $area = Area::find($id);
            $cities = City::latest('id')->get();
            return view('admin.location.areas.edit', compact('cities', 'area'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error', __('message.something_wrong')]);
        }
    }

    public function update(AreaRequest $request, $id)
    {
        try {
            $area = Area::find($id);
            $update_area = $area->update($request->except(['_token']));
            return redirect()->route('areas.index')->with(['success' => __('message.updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error', __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $area = Area::find($id);
            $area->delete();
            return redirect()->route('areas.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error', __('message.something_wrong')]);
        }
    }

    public function get_areas_of_city($id)
    {
        $areas = Area::where('city_id', $id)->get();
        $data = compact('areas');
        return response()->json(['status' => true, 'data' => $data]);
    }
}
