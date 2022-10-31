<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreProfileVehicle;
use App\Http\Requests\API\StoreVehicleForSale;
use App\Http\Requests\API\UpdateVehicleForSale;
use App\Http\Resources\Vehicles\GetVehiclesForSaleResource;
use App\Http\Resources\Vehicles\ProfileVehiclesResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class MawaterController extends Controller
{
    public function index()
    {
        try {
            $vehicles = Vehicle::where('user_vehicle_status', 'for_sale')->active()->overView()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($vehicles))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetVehiclesForSaleResource::collection($vehicles)->response()->getData());
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    // store used vehicle for sale
    public function store(StoreVehicleForSale $request)
    {
        try {
            // auth user
            $user = getAuthAPIUser();

            $request->merge(['active' => 1]);
            $request->merge(['availability' => 1]);
            $record = $request->all();
            if ($request->in_bahrain == false) {
                $record['country_id'] = $request->country_id;
            }
            if ($request->guarantee == true) {
                $record['guarantee_month'] = $request->guarantee_month;
                $record['guarantee_year'] = $request->guarantee_year;
            }
            if ($request->insurance == true) {
                $record['insurance_month'] = $request->insurance_month;
                $record['insurance_year'] = $request->insurance_year;
            }
            if ($request->selling_by_plate == true) {
                $record['number_plate'] = $request->number_plate;
            }
            $record['is_new'] = 0;
            $record['user_vehicle_status'] = 'for_sale';
            $used_vehicle = $user->vehicles()->create($record);
            $used_vehicle->upload_car_for_sale_Images();
            if (empty($used_vehicle))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', $used_vehicle);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    // update used vehicle for sale
    public function update(UpdateVehicleForSale $request)
    {
        try {
            // auth user
            $user = getAuthAPIUser();

            $record = $request->except('images');
            if ($request->in_bahrain == false) {
                $record['country_id'] = $request->country_id;
            }
            if ($request->guarantee == true) {
                $record['guarantee_month'] = $request->guarantee_month;
                $record['guarantee_year'] = $request->guarantee_year;
            }
            if ($request->insurance == true) {
                $record['insurance_month'] = $request->insurance_month;
                $record['insurance_year'] = $request->insurance_year;
            }
            if ($request->selling_by_plate == true) {
                $record['number_plate'] = $request->number_plate;
            }
            $record['is_new'] = 0;
            $profile_car = Vehicle::find($request->id);
            $profile_car->update($record);
            $profile_car->update_car_for_sale_Images();
            return responseJson(1, 'success', $profile_car);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }

    }

    // delete used vehicle for sale
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:vehicles,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());

        try {
            // auth user
            $user = getAuthAPIUser();

            $profile_car = Vehicle::find($request->id);
            $profile_car->delete();
            $profile_car->deleteImages();
            return responseJson(1, 'success');
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }

    }

    // get users sell vehicles
    public function sell_cars()
    {
        try {
            // auth user
            $user = getAuthAPIUser();

            $sale_vehicle = $user->vehicles()->with('brand', 'car_model', 'car_class')->active()->overView()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($sale_vehicle))
                return responseJson(0, __('message.no_result'));

            return responseJson(1, 'success', GetVehiclesForSaleResource::collection($sale_vehicle)->response()->getData());
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    //add vehicles for users
    public function store_profile_vehicle(StoreProfileVehicle $request)
    {
        try {
            // auth user
            $user = getAuthAPIUser();

            $request->merge(['active' => 1]);
            $request->merge(['is_new' => 0]);

            $record = $request->except('images', 'additional_maintenance');

            $profile_vehicle = $user->vehicles()->create($record);

            if ($request->has('additional_maintenance')) {
                foreach ($request->additional_maintenance as $additional) {
                    $profile_vehicle->additional_maintenance_history()->create($additional);
                }
            }

            $profile_vehicle->upload_car_for_sale_Images();

            return responseJson(1, 'success', new ProfileVehiclesResource($profile_vehicle));

        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    // get user profile vehicles
    public function get_vehicles()
    {
        try {
            // auth user
            $user = getAuthAPIUser();


            $cars = $user->vehicles()->with(['brand', 'car_model', 'car_class', 'files'])->myCarsSelection()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if ($cars->isEmpty())
                return responseJson(0, __('message.no_result'));

            foreach ($cars as $car) {
                $car->time = Carbon::createFromFormat('Y-m-d H:i:s', $car->created_at)->format('d-m-Y H:i A');
            }

            return responseJson(1, 'success', ProfileVehiclesResource::collection($cars)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

}
