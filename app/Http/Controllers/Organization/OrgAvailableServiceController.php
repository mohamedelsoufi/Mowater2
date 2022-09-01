<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;

class OrgAvailableServiceController extends Controller
{
    public function index()
    {
        $user               = auth()->guard('web')->user();
        $organization       = $user->organizable;
        
        $available_services = $organization->available_services;

        return view('organization.available_services.index' , compact('organization' , 'available_services'));
    }

    public function create()
    {
        $user         = auth()->guard('web')->user();
        $branch       = $user->organizable;
        $organization = $branch->branchable; //agency

        $services           = $organization->services;
        $available_services = $branch->available_services->pluck('id')->toArray();

        return view('organization.available_services.create' , compact('branch' , 'services' , 'available_services'));
    }

    public function store(Request $request)
    {
        $rules = [
            'services'    => 'nullable|array',
            'services.*'  => 'exists:services,id',
        ];

        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable; //branch

        $organization->available_services()->sync($request->services);  //services should belongs to this org
        

        return redirect()->route('organization.available_service.index')->with('success' , __('message.created_successfully'));
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
