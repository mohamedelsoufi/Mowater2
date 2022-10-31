<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgRentalReservationController extends Controller
{
    public function index()
    {
        $user                 = auth()->guard('web')->user();
        $organization         = $user->organizable;
        $rental_reservations  = $organization->rental_reservations;

        return view('organization.rental_reservations.index' , compact('organization' , 'rental_reservations'));
    }

    public function create()
    {
        return view('organization.rental_reservations.create');
    }

    public function store(Request $request)
    {
        $rules = [

        ];

        $request->validate($rules);

        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $organization->rental_reservations()->create($request->all());

        return redirect()->route('organization.rental_reservation.index')->with('success' , __('message.created_successfully'));
    }

    public function show($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $rental_reservation = $organization->rental_reservations()->where('rental_reservations.id' , $id)->firstOrFail();
        $data = compact('rental_reservation');

        return view('organization.rental_reservations.show' , compact('organization' , 'rental_reservation'));
    }

    public function edit($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $rental_reservation = $organization->rental_reservations()->where('rental_reservations.id' , $id)->firstOrFail();

        return view('organization.rental_reservations.edit' , compact('organization' , 'rental_reservation'));
    }


    public function update(Request $request , $id)
    {
        $user                = auth()->guard('web')->user();
        $organization        = $user->organizable;
        $rental_reservation  = $organization->rental_reservations()->where('rental_reservations.id' , $id)->firstOrFail();

        if($request->filled('status'))
        {
            $rental_reservation->status = $request->status;
            $rental_reservation->save();
        }

        return redirect()->route('organization.rental_reservation.index')->with('success' , __('message.updated_successfully'));

    }

    public function destroy($id)
    {
        $user         = auth()->guard('web')->user();
        $organization = $user->organizable;

        $rental_reservation = $organization->rental_reservations()->where('rental_reservations.id' , $id)->firstOrFail();


        if($rental_reservation)
        {
            $rental_reservation->delete();
            return redirect()->route('organization.rental_reservation.index')->with('success' , __('message.deleted_successfully'));
        }
        else
        {
            return back()->with(['error'=> __('message.something_wrong')]);
        }
    }


}
