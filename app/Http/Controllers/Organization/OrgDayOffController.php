<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgDayOffController extends Controller
{
    public function index()
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
        $day_offs    = $organization->day_offs;

        return view('organization.day_offs.index' , compact('organization' , 'day_offs'));
    }

    public function create()
    {
        return view('organization.day_offs.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'date' => 'required'
        ];

        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $organization->day_offs()->create($request->all());

        return redirect()->route('organization.day_off.index')->with('success' , __('message.created_successfully'));
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $day_off = $organization->day_offs()->where('day_offs.id' , $id)->firstOrFail();

        return view('organization.day_offs.edit' , compact('organization' , 'day_off'));
    }


    public function update(Request $request , $id)
    {
        $rules = [
            'facebook_link'    => 'nullable|url',
            'whatsapp_number'  => 'nullable|max:255',
            'country_code'            => 'required',
            'phone'            => 'nullable|numeric',
            'website'          => 'nullable|url',
            'instagram_link'   => 'nullable|url',
        ];


        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $day_off = $organization->day_offs()->where('day_offs.id' , $id)->firstOrFail();


        if($day_off)
        {
            $day_off->update($request->all());
            return redirect()->route('organization.day_off.index')->with('success' , __('message.updated_successfully'));
        }
        else
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }


    }

    public function destroy($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $day_off = $organization->day_offs()->where('day_offs.id' , $id)->firstOrFail();


        if($day_off)
        {
            $day_off->delete();
            return redirect()->route('organization.day_off.index')->with('success' , __('message.deleted_successfully'));
        }
        else
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }
    }


}
