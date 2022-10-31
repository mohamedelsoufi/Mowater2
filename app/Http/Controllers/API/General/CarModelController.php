<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\GetCarModelsRequest;
use App\Http\Requests\API\showCarModelRequest;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarModelController extends Controller
{
    public function index(GetCarModelsRequest $request)
    {
        try {
            $car_models = CarModel::with('brand')->where('brand_id', $request->brand_id)
                ->selection()->search()->active()->latest('id')->paginate(PAGINATION_COUNT);
            return responseJson(1, 'success', $car_models);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getManufacturingYears(showCarModelRequest $request)
    {
        try {
            $manufacturing_years = Vehicle::where('car_model_id',$request->car_model_id)->where('brand_id',$request->brand_id)
                ->pluck('manufacturing_year')->unique()->toArray();

            return responseJson(1, 'success', array_values($manufacturing_years));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
