<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgRentalLawController extends Controller
{
    public function index()
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
        $rental_laws  = $organization->rental_laws;

        return view('organization.rental_laws.index' , compact('organization' , 'rental_laws'));
    }

    public function create()
    {
        return view('organization.rental_laws.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title_en' => 'required|max:255',
            'title_ar' => 'required|max:255',
        ];

        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $organization->rental_laws()->create($request->all());
        
        return redirect()->route('organization.rental_law.index')->with('success' , __('message.created_successfully'));
    }

    public function show($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $rental_law = $organization->rental_laws()->where('rental_laws.id' , $id)->firstOrFail();
        $rental_law->makeVisible('title_en', 'title_ar');
        $data = compact('rental_law');
        return response()->json(['status' => true, 'data'=>$data]);
    }

    public function edit($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $rental_law = $organization->rental_laws()->where('rental_laws.id' , $id)->firstOrFail();

        return view('organization.rental_laws.edit' , compact('organization' , 'rental_law'));
    }


    public function update(Request $request , $id)
    {
        $rules = [
            'title_en' => 'required|max:255',
            'title_ar' => 'required|max:255',
        ];
        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            $validator->errors()->add('update_modal', $request->id);
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
    
        $rental_law = $organization->rental_laws()->where('rental_laws.id' , $id)->firstOrFail();

        
        if($rental_law)
        {
            $rental_law->update($request->all());
            return redirect()->route('organization.rental_law.index')->with('success' , __('message.updated_successfully'));
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
    
        $rental_law = $organization->rental_laws()->where('rental_laws.id' , $id)->firstOrFail();

        
        if($rental_law)
        {
            $rental_law->delete();
            return redirect()->route('organization.rental_law.index')->with('success' , __('message.deleted_successfully'));
        }
        else 
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }
    }


}
