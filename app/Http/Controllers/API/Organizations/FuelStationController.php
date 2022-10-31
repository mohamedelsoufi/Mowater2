<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\NearestLocationRequest;
use App\Http\Requests\API\ShowFuelStationRequest;
use App\Http\Resources\FuelStations\GetFuelStationsResource;
use App\Http\Resources\FuelStations\GetNearestFuelStationsResource;
use App\Http\Resources\FuelStations\ShowFuelStationResource;
use App\Models\FuelStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FuelStationController extends Controller
{
    public function index()
    {
        try {
            $fuel_stations = FuelStation::active()->available()
                ->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($fuel_stations))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetFuelStationsResource::collection($fuel_stations)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowFuelStationRequest $request)
    {
        try {
            $fuel_station = FuelStation::active()->find($request->id);
            if (empty($fuel_station))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($fuel_station);
            //update number of views end

            return responseJson(1, 'success', new ShowFuelStationResource($fuel_station));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function nearest_location(NearestLocationRequest $request)
    {
        try {
            $data = getNearestLocation("fuel_stations")->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetNearestFuelStationsResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
