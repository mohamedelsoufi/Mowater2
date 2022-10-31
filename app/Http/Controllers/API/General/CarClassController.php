<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\GetEngineSizesRequest;
use App\Http\Resources\Vehicles\GetEngineSizesResource;
use App\Models\CarClass;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class CarClassController extends Controller
{
    public function index()
    {
        try {
            $car_calsses = CarClass::selection()->active()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if ($car_calsses->isEmpty())
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', $car_calsses);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getEngineSize(GetEngineSizesRequest $request){
        try {
            $engine_sizes = Vehicle::where('brand_id',$request->brand_id)
            ->where('car_model_id',$request->car_model_id)
            ->where('manufacturing_year',$request->manufacturing_year)
            ->where('car_class_id',$request->car_class_id)->paginate(PAGINATION_COUNT);

            return responseJson(1, 'success', GetEngineSizesResource::collection($engine_sizes)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
