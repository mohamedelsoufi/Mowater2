<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowCarShowroomRequest;
use App\Http\Resources\Vehicles\GetVehicleMowaterOffersResource;
use App\Http\Resources\Vehicles\GetVehicleOffersResource;
use App\Models\Branch;
use App\Models\CarShowroom;
use App\Models\MainVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarShowroomController extends Controller
{
    public function index()
    {
        try {
            $car_show_rooms = CarShowroom::with('payment_methods', 'contact', 'work_time', 'reviews')->selection()->active()->available()
                ->search()->latest('id')->paginate(PAGINATION_COUNT);

            foreach ($car_show_rooms as $car_show_room) {
                $count = $car_show_room->reviews->count();
                $rate = $car_show_room->reviews->sum('rate');
                if ($count == 0) {
                    $car_show_room->rate = 0;
                } else {
                    $average = $rate / $count;
                    $car_show_room->rate = $average;
                }
            }
            if (empty($car_show_rooms))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', $car_show_rooms);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowCarShowroomRequest $request)
    {
        try {
            $car_showroom = CarShowroom::with(['payment_methods', 'country', 'city', 'area', 'work_time', 'contact', 'reviews'])->selection()->active()->find($request->id);
            if (empty($car_showroom))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($car_showroom);
            //update number of views end

            $car_showroom->barnds = $car_showroom->getBrands();

            return responseJson(1, 'success', $car_showroom);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getDiscountCardOffers(ShowCarShowroomRequest $request)
    {
        try {
            $car_showroom = CarShowroom::selection()->active()->find($request->id);

            $discount_cards = $car_showroom->discount_cards()->where('status', 'started')->get();

            if (!$discount_cards->isEmpty()) {
                $vehicles = $car_showroom->vehicles()->with(['brand', 'car_model', 'car_class', 'files' => function ($query) {
                    $query->with('color');
                }])->overView()->wherehas('offers')->paginate(PAGINATION_COUNT);
                if (empty($vehicles))
                    return responseJson(0, __('message.no_result'));
                vehicleMowaterCard($vehicles);

                return responseJson(1, 'success', GetVehicleMowaterOffersResource::collection($vehicles)->response()->getData(true));

            } else {
                return responseJson(0, 'error', __('message.no_result'));
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getOffers(ShowCarShowroomRequest $request)
    {
        try {
            $car_showroom = CarShowroom::active()->find($request->id);

            // items not in mowater card and have offers start
            $vehicles = $car_showroom->vehicles()->where('discount_type', '!=', '')->latest('id')->get();
            if (isset($vehicles))
                $vehicles->each(function ($item) {
                    $item->is_mowater_card = false;
                });
            // items not in mowater card and have offers end

            // items have mowater card start
            $mowater_vehicles = $car_showroom->vehicles()->overView()->wherehas('offers')->latest('id')->get();

            if (isset($mowater_vehicles)) {
                vehicleOffers($mowater_vehicles);
            }
            // items have mowater card end

            //merge all results in one array
            $merged =collect(GetVehicleOffersResource::collection($vehicles))
                ->merge(GetVehicleOffersResource::collection($mowater_vehicles))->paginate(PAGINATION_COUNT);

            return responseJson(1, 'success', $merged);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
