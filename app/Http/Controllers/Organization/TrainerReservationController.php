<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\BrokerReservation;
use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryManReservation;
use App\Models\Reservation;
use App\Models\TrainingReservation;
use App\Models\User;
use Illuminate\Http\Request;

class TrainerReservationController extends Controller
{
    public function index()
    {
        $user = auth()->guard('web')->user();
        $organization = $user->organizable;
        $reservations = $organization->reservations;
        return view('organization.trainer_reservations.index', compact('reservations'));
    }

    public function show($id)
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $countries = Country::all();
        $cities = City::all();
        $areas = Area::all();
        $reservation = TrainingReservation::find($id);
        $user = User::find($reservation->user_id);
        return view('organization.trainer_reservations.show', compact('reservation', 'user', 'countries', 'cities', 'areas'));
    }

    public function edit($id)
    {
        $user = auth()->guard('web')->user();
        $show_reservation = TrainingReservation::find($id);
        $user = User::find($show_reservation->user_id);
        return view('organization.trainer_reservations.change_status', compact('show_reservation', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->guard('web')->user();
        $reservation = TrainingReservation::findOrFail($id);
        $reservation['status'] = $request->status;
//        $reservation['price'] = $request->price;
        $reservation->save();
        return redirect()->route('organization.trainer_reservations.index')->with(['success' => __('message.updated_successfully')]);
    }

}
