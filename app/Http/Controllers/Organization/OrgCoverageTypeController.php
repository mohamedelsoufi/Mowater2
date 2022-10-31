<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\CarClass;

class OrgCoverageTypeController extends Controller
{
    public function index()
    {
        $user               = auth()->guard('web')->user();
        $organization       = $user->organizable;
        $coverage_types     = $organization->coverage_types;

        return view('organization.coverage_types.index' , compact('organization' , 'coverage_types'));
    }

    public function create()
    {
        return view('organization.coverage_types.create');
    }

    public function store(Request $request)
    {
        //return $request;
        $rules = [
           'name_en'          => 'required|max:255',
           'name_ar'          => 'required|max:255',
           'features_name_en' => 'nullable|array',
           'features_name_en' => 'max:255',
           'features_name_ar' => 'nullable|array',
           'features_name_ar' => 'max:255',
           'features_price'   => 'nullable|array',
           'features_price.*' => 'nullable|numeric',
        ];

        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $coverage_type = $organization->coverage_types()->create($request->all());

        if($request->filled('features_name_en'))
        {
            foreach($request->features_name_en as $key => $value)
            {
                if($request->features_name_en[$key] || $request->features_name_ar[$key] )
                {
                    $coverage_type->features()->create([
                        'name_en' => $request->features_name_en[$key],
                        'name_ar' => $request->features_name_ar[$key],
                        'price'   => $request->features_price[$key],
                    ]);
                }
             
            }
        }
        
        return redirect()->route('organization.coverage_type.index')->with('success' , __('message.created_successfully'));
    }

    public function show($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $coverage_type = $organization->coverage_types()->with('car_model')->where('coverage_types.id' , $id)->firstOrFail();
        $data = compact('coverage_type');
        return response()->json(['status' => true, 'data'=>$data]);
    }

    public function edit($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $coverage_type = $organization->coverage_types()->with('features')->where('coverage_types.id' , $id)->firstOrFail();
        //return $coverage_type;
        return view('organization.coverage_types.edit' , compact('organization' , 'coverage_type'));
    }


    public function update(Request $request , $id)
    {
        $rules = [
            'name_en'          => 'required|max:255',
            'name_ar'          => 'required|max:255',
            'features_name_en' => 'nullable|array',
            'features_name_en' => 'max:255',
            'features_name_ar' => 'nullable|array',
            'features_name_ar' => 'max:255',
            'features_price'   => 'nullable|array',
            'features_price.*' => 'nullable|numeric',
        ];

        $request->validate($rules);
     
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
        
    
        $coverage_type = $organization->coverage_types()->where('coverage_types.id' , $id)->firstOrFail();

        
        $coverage_type->update($request->all());
        $coverage_type->features()->delete();

        if($request->filled('features_name_en'))
        {
            foreach($request->features_name_en as $key => $value)
            {
                if($request->features_name_en[$key] || $request->features_name_ar[$key] )
                {
                    $coverage_type->features()->create([
                        'name_en' => $request->features_name_en[$key],
                        'name_ar' => $request->features_name_ar[$key],
                        'price'   => $request->features_price[$key],
                    ]);
                }
               
            }
        }
    
        return redirect()->route('organization.coverage_type.index')->with('success' , __('message.updated_successfully'));
      
    }

    public function destroy($id)
    {  
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
    
        $coverage_type = $organization->coverage_types()->where('coverage_types.id' , $id)->firstOrFail();

        if($coverage_type)
        {
            $coverage_type->delete();
            return redirect()->route('organization.coverage_type.index')->with('success' , __('message.deleted_successfully'));
        }
        else 
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }
    }


}
