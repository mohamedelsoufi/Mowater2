<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgContactController extends Controller
{

    public function edit()
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
        $contact      = $organization->contact;

        return view('organization.contact.edit' , compact('organization' , 'contact'));
    }


    public function update(Request $request)
    {
        $rules = [
            'facebook_link'    => 'nullable|url',
            'whatsapp_number'  => 'nullable|max:255',
            'country_code'            => 'required',
            'phone'            => 'nullable|integer',
            'website'          => 'nullable|url',
            'instagram_link'   => 'nullable|url',
        ];


        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;
        $contact    = $organization->contact;

        if($contact)
        {
            $contact->update($request->all());
        }
        else
        {
            $organization->contact()->create($request->all());
        }

        return back()->with('success' , __('message.updated_successfully'));
    }


}
