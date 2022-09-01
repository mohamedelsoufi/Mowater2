<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;

class OrgAvailableProductController extends Controller
{
    public function index()
    {
        $user               = auth()->guard('web')->user();
        $organization       = $user->organizable;
        
        $available_products = $organization->available_products;

        return view('organization.available_products.index' , compact('organization' , 'available_products'));
    }

    public function create()
    {
        $user         = auth()->guard('web')->user();
        $branch       = $user->organizable;
        $organization = $branch->branchable; //agency

        $products           = $organization->products;
        $available_products = $branch->available_products->pluck('id')->toArray();

        return view('organization.available_products.create' , compact('branch' , 'products' , 'available_products'));
    }

    public function store(Request $request)
    {
        $rules = [
            'products'    => 'nullable|array',
            'products.*'  => 'exists:products,id',
        ];

        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable; //branch

        $organization->available_products()->sync($request->products);  //products should belongs to this org
        
        return redirect()->route('organization.available_product.index')->with('success' , __('message.created_successfully'));
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
