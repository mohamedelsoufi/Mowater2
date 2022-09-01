<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgPhoneController extends Controller
{
    public function index()
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
        $phones       = $organization->phones;

        return view('organization.phones.index' , compact('organization' , 'phones'));
    }

    public function create()
    {
        return view('organization.phones.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'country_code'    => 'required',
            'phone'    => 'required|integer',
            'title_en' => 'nullable|max:255',
            'title_ar' => 'nullable|max:255',
        ];

        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $organization->phones()->create($request->all());

        return redirect()->route('organization.phone.index')->with('success' , __('message.created_successfully'));
    }

    public function show($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $phone = $organization->phones()->where('phones.id' , $id)->firstOrFail();
        $data = compact('phone');
        return response()->json(['status' => true, 'data'=>$data]);
        //return view('organization.phones.edit' , compact('organization' , 'phone'));
    }

    public function edit($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $phone = $organization->phones()->where('phones.id' , $id)->firstOrFail();

        return view('organization.phones.edit' , compact('organization' , 'phone'));
    }


    public function update(Request $request , $id)
    {
        $rules = [
            'country_code'    => 'required',
            'phone'    => 'required|integer',
            'title_en' => 'nullable|max:255',
            'title_ar' => 'nullable|max:255',
        ];
        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            $validator->errors()->add('update_modal', $request->id);
            return redirect()->back()->withInput()->withErrors($validator);
            //return $validator->errors();
            //return redirect()->route('organization.phone.index')->withInput()->;
            //return redirect()->route('organization.phone.index')->withErrors($validator)->withInput()->with(['errors' => $validator->errors() , 'error' => $validator->errors()]);

        }


        //return $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $phone = $organization->phones()->where('phones.id' , $id)->firstOrFail();


        if($phone)
        {
            $phone->update($request->all());
            return redirect()->route('organization.phone.index')->with('success' , __('message.updated_successfully'));
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

        $phone = $organization->phones()->where('phones.id' , $id)->firstOrFail();


        if($phone)
        {
            $phone->delete();
            return redirect()->route('organization.phone.index')->with('success' , __('message.deleted_successfully'));
        }
        else
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }
    }


}
