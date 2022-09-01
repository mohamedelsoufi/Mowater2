<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\BrokerReservation;
use App\Models\City;
use App\Models\Country;
use App\Models\Reservation;
use App\Models\TrainingReservation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DeliveryManReservation;

class OrgReservationsController extends Controller
{
    public function index()
    {
        $user = auth()->guard('web')->user();
        $organization = $user->organizable;
        $model_type = $user->organizable_type;
        $reservations = $organization->reservations;
//        if ($model_type == 'App\Models\DrivingTrainer') {
//            return view('organization.trainer_reservations.index', compact('reservations'));
//        }

        return view('organization.reservations.index', compact('reservations'));
    }

    public function show($id)
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
        $countries = Country::all();
        $cities = City::all();
        $areas = Area::all();
//        if ($model_type == 'App\Models\DeliveryMan') {
//            $reservation = DeliveryManReservation::find($id);
//            $reservation->category;
//        } else if ($model_type == 'App\Models\DrivingTrainer') {
//            $reservation = TrainingReservation::find($id);
//            $user = User::find($reservation->user_id);
//            return view('organization.trainer_reservations.show', compact('reservation', 'user', 'countries', 'cities', 'areas'));
        if ($model_type == 'App\Models\Broker') {
            $reservation = BrokerReservation::findOrFail($id);
        } else {
            $reservation = Reservation::find($id);
        }
        $user = User::find($reservation->user_id);
        return view('organization.reservations.show', compact('reservation', 'user', 'countries', 'cities', 'areas'));
    }

    public
    function edit($id)
    {
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;
//        if ($model_type == 'App\Models\DeliveryMan') {
//            $show_reservation = DeliveryManReservation::find($id);
//        } else if ($model_type == 'App\Models\DrivingTrainer') {
//            $show_reservation = TrainingReservation::find($id);
//            $user = User::find($show_reservation->user_id);
//            return view('organization.trainer_reservations.change_status', compact('show_reservation', 'user'));
        if ($model_type == 'App\Models\Broker') {
            $show_reservation = BrokerReservation::findOrFail($id);
        } else {
            $show_reservation = Reservation::find($id);
        }
        $user = User::find($show_reservation->user_id);

        return view('organization.reservations.change_status', compact('show_reservation', 'user'));
    }

    public function update(Request $request, $id)
    {
//        return $request;
        $user = auth()->guard('web')->user();
        $model_type = $user->organizable_type;

        if ($model_type == 'App\Models\DeliveryMan') {
            $reservation = DeliveryManReservation::find($id);
            //        return $reservation->status;
        } else if ($model_type == 'App\Models\Broker') {
            $reservation = BrokerReservation::findOrFail($id);
        } else if ($model_type == 'App\Models\DrivingTrainer') {
            $reservation = TrainingReservation::findOrFail($id);
        } else {
            $reservation = Reservation::find($id);
        }
        $reservation['status'] = $request->status;
        $reservation['price'] = $request->price;

        $reservation->save();
        return redirect()->route('organization.reservations.index')->with(['success' => __('message.updated_successfully')]);
    }

    public function delivery_details(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        if ($request->delivery_day) {
            $reservation->delivery_day = $request->delivery_day;
        }
        if ($request->delivery_fees) {
            $reservation->delivery_fees = $request->delivery_fees;
        }
        $reservation->update();
        return redirect()->route('organization.reservations.index')->with(['success' => __('message.updated_successfully')]);
    }

    public function getlocation()
    {
        $geolocation = '29.8221568' . ',' . '31.3655296';
        $request = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $geolocation . '&sensor=false';
        $file_contents = file_get_contents($request);
        return $json_decode = json_decode($file_contents);
    }
}
