<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgVehicleTestController extends Controller
{
    public function index()
    {
        $user                = auth()->guard('web')->user();
        $organization        = $user->organizable;
        $tests    = $organization->tests()->where(function($query){
                        if(request()->branch_id)
                        {
                            $query->where('branch_id' , request()->branch_id);
                        }
                    })->get();;

        $branches = $organization->branches ?? [];

        return view('organization.tests.index' , compact('organization' , 'tests' , 'branches'));
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
        $test     = $organization->tests()->where('test_drives.id' , $id)->firstOrFail();

        return view('organization.tests.show' , compact('organization' , 'test'));
    }

    public function edit($id)
    {
       
    }


    public function update(Request $request , $id)
    {
        $user                = auth()->guard('web')->user();
        $organization        = $user->organizable;
        $test     = $organization->tests()->where('test_drives.id' , $id)->firstOrFail();

        if($request->filled('status'))
        {
            $test->status = $request->status;
            $test->save();
        }

        return redirect()->route('organization.test.index')->with('success' , __('message.updated_successfully'));
    }

    public function destroy($id)
    {  
       
    }


}
