<?php

namespace App\Http\Controllers\Dashboard\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-cities'])->only('index');
        $this->middleware(['permission:create-cities'])->only('create');
        $this->middleware(['permission:update-cities'])->only('edit');
        $this->middleware(['permission:delete-cities'])->only('delete');
    }

    public function index()
    {
        try {
            $cities = City::latest('id')->get();
            $countries = Country::latest('id')->get();
            return view('admin.location.cities.index', compact('cities', 'countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $city = City::find($id);
            return view('admin.location.cities.show', compact('city'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        try {
            $countries = Country::latest('id')->get();
            return view('admin.location.cities.create', compact('countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function store(CityRequest $request)
    {
        try {
            $city = City::create($request->except(['_token']));
            if ($city) {
                return redirect()->route('cities.index')->with(['success' => __('message.created_successfully')]);
            } else {

                return redirect()->back()->with(['error' => __('message.something_wrong')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $city = City::find($id);
            $countries = Country::latest('id')->get();
            return view('admin.location.cities.edit', compact('countries', 'city'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(CityRequest $request, $id)
    {
        try {
            $city = City::find($id);
            $update_city = $city->update($request->except(['_token']));
            if ($update_city) {
                return redirect()->route('cities.index')->with(['success' => __('message.updated_successfully')]);
            } else {
                return redirect()->route('cities.index')->with(['error' => __('message.something_wrong')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function destroy($id)
    {
        try {
            $city = City::find($id);
            $city->delete();
            return redirect()->route('cities.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function get_cities_of_country($id)
    {
        $cities = City::where('country_id', $id)->get();
        $data = compact('cities');
        return response()->json(['status' => true, 'data' => $data]);
    }
}
