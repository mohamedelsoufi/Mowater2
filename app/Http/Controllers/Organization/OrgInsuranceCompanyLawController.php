<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgInsuranceCompanyLawController extends Controller
{
    public function index()
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
        $laws         = $organization->laws;

        return view('organization.laws.index' , compact('organization' , 'laws'));
    }

    public function create()
    {
        return view('organization.laws.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'law_en' => 'required|max:255',
            'law_ar' => 'required|max:255',
        ];

        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $organization->laws()->create($request->all());
        
        return redirect()->route('organization.law.index')->with('success' , __('message.created_successfully'));
    }

    public function show($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $law = $organization->laws()->where('insurance_company_laws.id' , $id)->firstOrFail();
        $law->makeVisible('law_en', 'law_ar');
        $data = compact('law');
        return response()->json(['status' => true, 'data'=>$data]);
    }

    public function edit($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $law = $organization->laws()->where('insurance_company_laws.id' , $id)->firstOrFail();

        return view('organization.laws.edit' , compact('organization' , 'law'));
    }


    public function update(Request $request , $id)
    {
        $rules = [
            'law_en' => 'required|max:255',
            'law_ar' => 'required|max:255',
        ];
        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            $validator->errors()->add('update_modal', $request->id);
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
    
        $law = $organization->laws()->where('insurance_company_laws.id' , $id)->firstOrFail();

        
        if($law)
        {
            $law->update($request->all());
            return redirect()->route('organization.law.index')->with('success' , __('message.updated_successfully'));
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
    
        $law = $organization->laws()->where('insurance_company_laws.id' , $id)->firstOrFail();

        
        if($law)
        {
            $law->delete();
            return redirect()->route('organization.law.index')->with('success' , __('message.deleted_successfully'));
        }
        else 
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }
    }


}
