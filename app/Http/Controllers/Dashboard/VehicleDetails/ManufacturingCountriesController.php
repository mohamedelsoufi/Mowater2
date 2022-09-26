<?php

namespace App\Http\Controllers\Dashboard\VehicleDetails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManufactureCountryRequest;
use App\Models\ManufactureCountry;


class ManufacturingCountriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-manufacture_countries'])->only('index');
        $this->middleware(['permission:create-manufacture_countries'])->only('create');
        $this->middleware(['permission:update-manufacture_countries'])->only('edit');
        $this->middleware(['permission:delete-manufacture_countries'])->only('delete');
    }

    public function index()
    {
        try {
            $manufacture_countries = ManufactureCountry::latest('id')->get();
            return view('admin.vehicle_details.manufacture_countries.index', compact('manufacture_countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $manufacture_country = ManufactureCountry::find($id);
            return view('admin.vehicle_details.manufacture_countries.show', compact('manufacture_country'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        return view('admin.vehicle_details.manufacture_countries.create');
    }

    public function store(ManufactureCountryRequest $request)
    {
        try {
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);
            $request_data =$request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $manufacture_country = ManufactureCountry::create($request_data);
            if ($manufacture_country) {
                return redirect()->route('manufacture-countries.index')->with(['success' => __('message.created_successfully')]);
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
            $manufacture_country = ManufactureCountry::find($id);
            return view('admin.vehicle_details.manufacture_countries.edit', compact('manufacture_country'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(ManufactureCountryRequest $request, $id)
    {
        try {
            $manufacture_country = ManufactureCountry::find($id);
            if (!$request->has('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' => 1]);
            $request_data =$request->except(['_token']);
            $request_data['created_by'] = auth('admin')->user()->email;
            $update_manufacture_country = $manufacture_country->update($request_data);
            if ($update_manufacture_country) {
                return redirect()->route('manufacture-countries.index')->with(['success' => __('message.updated_successfully')]);
            } else {
                return redirect()->route('manufacture-countries.index')->with(['error' => __('message.something_wrong')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        try {
            $manufacture_country = ManufactureCountry::find($id);
            $manufacture_country->delete();
            return redirect()->route('manufacture-countries.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
