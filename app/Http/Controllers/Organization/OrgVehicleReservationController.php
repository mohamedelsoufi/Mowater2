<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgVehicleReservationController extends Controller
{
    public function index()
    {
        $user                = auth()->guard('web')->user();
        $organization        = $user->organizable;
        $reserve_vehicles    = $organization->reserve_vehicles()->where(function($query){
            if(request()->branch_id)
            {
                $query->where('branch_id' , request()->branch_id);
            }
        })->get();

        $branches = $organization->branches ?? [];

        return view('organization.reserve_vehicles.index' , compact('organization' , 'branches' , 'reserve_vehicles'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        $user                = auth()->guard('web')->user();
        $organization        = $user->organizable;
        $reserve_vehicle     = $organization->reserve_vehicles()->where('reserve_vehicles.id' , $id)->firstOrFail();

        return view('organization.reserve_vehicles.show' , compact('organization' , 'reserve_vehicle'));
    }

    public function edit($id)
    {

    }


    public function update(Request $request , $id)
    {
        $user                = auth()->guard('web')->user();
        $organization        = $user->organizable;
        $reserve_vehicle     = $organization->reserve_vehicles()->where('reserve_vehicles.id' , $id)->firstOrFail();

        if($request->filled('status'))
        {
            $reserve_vehicle->status = $request->status;
            $reserve_vehicle->save();
        }

        return redirect()->route('organization.reserve_vehicle.index')->with('success' , __('message.updated_successfully'));
    }

    public function destroy($id)
    {

    }


}
