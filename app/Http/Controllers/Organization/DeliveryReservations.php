<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryManReservation;
use App\Models\TrainingReservation;
use App\Models\User;
use Illuminate\Http\Request;

class DeliveryReservations extends Controller
{

    public function index()
    {
        $user = auth()->guard('web')->user();
        $organization = $user->organizable;
        $reservations = $organization->reservations;
        return view('organization.delivery_reservations.index', compact('reservations'));
    }

    public function show($id)
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $countries = Country::all();
        $cities = City::all();
        $areas = Area::all();
        $reservation = DeliveryManReservation::find($id);
        $user = User::find($reservation->user_id);
        return view('organization.delivery_reservations.show', compact('reservation', 'user', 'countries', 'cities', 'areas'));
    }

    public function edit($id)
    {
        $user = auth()->guard('web')->user();
        $show_reservation = DeliveryManReservation::find($id);
        $user = User::find($show_reservation->user_id);
        return view('organization.delivery_reservations.edit', compact('show_reservation', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->guard('web')->user();
        $reservation = DeliveryManReservation::findOrFail($id);
        $reservation['status'] = $request->status;
        $reservation['price'] = $request->price;
        $reservation->save();
        return redirect()->route('organization.delivery_reservations.index')->with(['success' => __('message.updated_successfully')]);
    }
}
