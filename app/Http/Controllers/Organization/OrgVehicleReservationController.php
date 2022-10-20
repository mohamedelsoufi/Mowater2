<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleReservationRequest;
use App\Models\ReserveVehicle;
use Illuminate\Http\Request;

class OrgVehicleReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['HasVehicleReservation:read'])->only(['index', 'show']);
        $this->middleware(['HasVehicleReservation:update'])->only('edit');
    }

    public function index()
    {
        try {
            $record = getModelData();
            $reservations = $record->reserve_vehicles()->latest('id')->get();
            return view('organization.vehiclesReservations.index', compact('record', 'reservations'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $reservation = $record->reserve_vehicles->find($id);
            return view('organization.vehiclesReservations.show', compact('record', 'reservation'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>$e->getMessage()]);
        }
    }

    public function update(VehicleReservationRequest $request,$id)
    {
        try {
            $reservation = ReserveVehicle::find($id);

            $request_data = $request->only('status');
            $request_data['action_by'] = auth('web')->user()->email;
            $reservation->update($request_data);

            return redirect()->back()->with('success', __('message.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

}
