<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowCarShowroomRequest;
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
        $car_show_rooms = CarShowroom::with('payment_methods','contact', 'work_time','reviews')->selection()->active()->available()
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
            return responseJson(0,__('message.no_result'));
        return responseJson(1, 'success', $car_show_rooms);
    }

    public function show(ShowCarShowroomRequest $request)
    {
        $car_showroom = CarShowroom::with(['payment_methods','country', 'city', 'area', 'work_time', 'contact', 'reviews'])->selection()->active()->find($request->id);
        if (empty($car_showroom))
            return responseJson(0,__('message.no_result'));
        //update number of views start
        updateNumberOfViews($car_showroom);
        //update number of views end

        $car_showroom->barnds = $car_showroom->getBrands();

        return responseJson(1, 'success', $car_showroom);
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
                    return responseJson(0,__('message.no_result'));
                foreach ($vehicles as $vehicle) {
                    foreach ($vehicle->offers as $offer) {
                        $discount_type = $offer->discount_type;
                        $percentage_value = ((100 - $offer->discount_value) / 100);
                        if ($discount_type == 'percentage') {
                            $price_after_discount = $vehicle->price * $percentage_value;
                            $vehicle->card_discount_value = $offer->discount_value . '%';
                            $vehicle->card_price_after_discount = $price_after_discount . ' BHD';
                            $vehicle->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                        } else {
                            $price_after_discount = $vehicle->price - $offer->discount_value;
                            $vehicle->card_discount_value = $offer->discount_value . ' BHD';
                            $vehicle->card_price_after_discount = $price_after_discount . ' BHD';
                            $vehicle->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                        }
                        $vehicle->notes = $offer->notes;
                        $vehicle->features = $vehicle->vehicleProperties();
                        $vehicle->makeHidden('offers');
                    }
                }

                return responseJson(1, 'success',  $vehicles);

            } else {
                return responseJson(0, 'error', __('message.no_result'));
            }
        }catch (\Exception $e){
            return responseJson(0,'error',$e->getMessage());
        }
    }
}
