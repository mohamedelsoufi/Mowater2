<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;

class OrgAvailableVehicleController extends Controller
{
    public function index()
    {
        $user               = auth()->guard('web')->user();
        $organization       = $user->organizable;
        $available_vehicles = $organization->available_vehicles;

        return view('organization.available_vehicles.index' , compact('organization' , 'available_vehicles'));
    }

    public function create()
    {
        $user         = auth()->guard('web')->user();
        $branch       = $user->organizable;
        $organization = $branch->branchable; //agency

        $vehicles           = $organization->vehicles;
        $available_vehicles = $branch->available_vehicles->pluck('id')->toArray();

        return view('organization.available_vehicles.create' , compact('branch' , 'vehicles' , 'available_vehicles'));
    }

    public function store(Request $request)
    {
        $rules = [
            'vehicles'    => 'nullable|array',
            'vehicles.*'  => 'exists:vehicles,id',
        ];

        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable; //branch

        $organization->available_vehicles()->sync($request->vehicles); //vehicles should belongs to this org
        

        return redirect()->route('organization.available_vehicle.index')->with('success' , __('message.created_successfully'));
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
       
    }


    public function update(Request $request , $id)
    {
       
    }

    public function destroy($id)
    {  
       
    }


}
