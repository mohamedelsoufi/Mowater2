<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgWorkTimeController extends Controller
{

    public function index()
    {
      
    }


    public function create()
    {
        return view('organization.work_time.create');
    }


    public function store(Request $request)
    {
        
    }


    public function show($id)
    {
        
    }


    public function edit()
    {
        $user        = auth()->guard('web')->user();
        $organization = $user->organizable;
        $work_time   = $organization->work_time;

        return view('organization.work_time.edit' , compact('organization' , 'work_time'));
    }


    public function update(Request $request)
    {
        $rules = [
            'from'      => 'required',
            'to'        => 'required',
            'duration'  => 'required|numeric',
            'work_days' => 'required|array',
        ];

       
        $request->validate($rules);
        
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
        $work_time    = $organization->work_time;

        $request->merge([
            'days' => implode("," , $request->work_days )
        ]);
        
        if($work_time)
        {
            $work_time->update($request->all());
        }
        else 
        {
            $organization->work_time()->create($request->all());
        }

        return back()->with('success' , __('message.updated_successfully'));
    }


    public function destroy($id)
    {
        //
    }
}
