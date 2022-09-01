<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class OrgAvailablePaymentMethodController extends Controller
{
    public function index()
    {
        $user                       = auth()->guard('web')->user();
        $organization               = $user->organizable;
        $payment_methods = PaymentMethod::get();
        $available_payment_methods  = $organization->payment_methods;

        return view('organization.available_payment_methods.index' , compact('organization' , 'available_payment_methods' , 'payment_methods'));
    }

    public function create()
    {
        $payment_methods = PaymentMethod::get();
        return view('organization.available_payment_methods.create' , compact('payment_methods'));
    }

    public function store(Request $request)
    {
        $rules = [
            'available_payment_methods'   => 'nullable|array',
            'available_payment_methods.*' => 'exists:payment_methods,id' 
        ];

        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $organization->payment_methods()->sync($request->available_payment_methods);
        
        return redirect()->route('organization.available_payment_method.index')->with('success' , __('message.created_successfully'));
    }

    public function show($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $available_payment_method = $organization->payment_methods()->where('payment_methods.id' , $id)->firstOrFail();
        $data = compact('available_payment_method');
        return response()->json(['status' => true, 'data'=>$data]);
    }

    public function edit($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $available_payment_method = $organization->available_payment_methods()->where('available_payment_methods.id' , $id)->firstOrFail();

        return view('organization.available_payment_methods.edit' , compact('organization' , 'available_payment_method'));
    }


    public function update(Request $request , $id)
    {
        $rules = [
            'available_payment_methods' => 'nullable|array|exists:payment_methods,id',
        ];

        $validator = validator()->make($request->all() , $rules);
        if($validator->fails())
        {
            $validator->errors()->add('update_modal', $request->id);
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
    
        $organization->available_payment_methods()->sync($request->available_payment_methods);

        return redirect()->route('organization.available_payment_method.index')->with('success' , __('message.updated_successfully'));
        
    }

    public function destroy($id)
    {  
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $organization->payment_methods()->detach($id);
       
        return redirect()->route('organization.available_payment_method.index')->with('success' , __('message.deleted_successfully'));
    }


}
