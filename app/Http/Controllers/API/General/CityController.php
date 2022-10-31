<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowCityRequest;
use App\Http\Resources\Cities\GetCitiesResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function index()
    {
        try {
            $cities = City::search()->latest('id')->paginate(PAGINATION_COUNT);
            return responseJson(1, 'success', GetCitiesResource::collection($cities)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowCityRequest $request)
    {
        try {
            $city = City::find($request->id);
            return responseJson(1, 'success', new  GetCitiesResource($city));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
