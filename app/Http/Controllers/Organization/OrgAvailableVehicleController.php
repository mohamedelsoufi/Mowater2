<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvailableVehicleRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;

class OrgAvailableVehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['HasAvailableVehicle:read'])->only(['index', 'show']);
        $this->middleware(['HasAvailableVehicle:update'])->only('edit');
    }

    public function index()
    {
        try {
            $record = getModelData();
            $availableVehicles = $record->available_vehicles()->latest('id')->get();
            return view('organization.availableVehicles.index', compact('record', 'availableVehicles'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $availableVehicle = $record->available_vehicles->find($id);
            $keys = array_keys($availableVehicle->vehicleProperties());
            return view('organization.availableVehicles.show', compact('record', 'availableVehicle','keys'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit()
    {
        try {
            $record = getModelData();
            $org = $record->branchable;
            $vehicles = $org->vehicles()->active()->available()->latest('id')->get();
            $availableVehicles = $record->available_vehicles()->pluck('usable_id')->toArray();
            return view('organization.availableVehicles.edit', compact('record', 'vehicles','availableVehicles'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function update(AvailableVehicleRequest $request)
    {
        try {
            $record = getModelData();

            $record->available_vehicles()->sync($request->available_vehicles);

            return redirect()->route('organization.available-vehicles.index')->with('success', __('message.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

}
