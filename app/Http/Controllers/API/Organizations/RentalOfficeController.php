<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RentalReservationRequest;
use App\Http\Requests\API\ShowRentalOfficeCarRequest;
use App\Http\Requests\API\ShowRentalOfficeRequest;
use App\Http\Resources\RentalOffices\GetRentalCarsMowaterResource;
use App\Http\Resources\RentalOffices\GetRentalCarsOffersResource;
use App\Http\Resources\RentalOffices\GetRentalOfficesResource;
use App\Http\Resources\RentalOffices\ShowRentalOfficeCarResource;
use App\Http\Resources\RentalOffices\ShowRentalOfficeResource;
use App\Http\Resources\RentalOffices\ShowUserRentalReservationResource;
use App\Models\DiscoutnCardUserUse;
use App\Models\Offer;
use App\Models\RentalOffice;
use App\Models\RentalOfficeCar;
use App\Models\RentalReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RentalOfficeController extends Controller
{

    public function index()
    {
        try {
            $rental_offices = RentalOffice::with('country', 'city', 'area', 'reviews')->active()
                ->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($rental_offices))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetRentalOfficesResource::collection($rental_offices)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowRentalOfficeRequest $request)
    {
        try {
            $rental_office = RentalOffice::active()->find($request->id);
            if (empty($rental_office))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($rental_office);
            //update number of views end

            return responseJson(1, 'success', new ShowRentalOfficeResource($rental_office));
        }catch (\Exception $e){
            return responseJson(0,'error',$e->getMessage());
        }
    }

    public function getRentalOfficeCars(ShowRentalOfficeRequest $request)
    {
        try {
            $rental_office = RentalOffice::active()->find($request->id);

            $rental_cars = $rental_office->rental_office_cars()->active()->search()->paginate(PAGINATION_COUNT);
            if (empty($rental_cars))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', ShowRentalOfficeCarResource::collection($rental_cars)->response()->getData(true));

        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show_rental_office_car(ShowRentalOfficeCarRequest $request)
    {
        try {
            $rental_car = RentalOfficeCar::active()->find($request->id);
            if (empty($rental_car))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($rental_car);
            //update number of views end

            return responseJson(1, 'success', new ShowRentalOfficeCarResource($rental_car));

        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getDiscountCardOffers(ShowRentalOfficeRequest $request)
    {
        $rental_office = RentalOffice::active()->find($request->id);

        $discount_cards = $rental_office->discount_cards()->where('status', 'started')->get();

        if (!$discount_cards->isEmpty()) {

             $vehicles = $rental_office->rental_office_cars()->wherehas('offers')->paginate(PAGINATION_COUNT);

            if (empty($vehicles))
                return responseJson(0, __('message.no_result'));

            rentalVehicleMowaterCard($vehicles);

            return responseJson(1, 'success', GetRentalCarsMowaterResource::collection($vehicles)->response()->getData(true));

        } else {
            return responseJson(0, 'error', __('message.something_wrong'));
        }

    }

    public function getOffers(ShowRentalOfficeRequest $request)
    {
        try {
            $rental_office = RentalOffice::active()->find($request->id);

            // items not in mowater card and have offers start
            $vehicles = $rental_office->rental_office_cars()->where('discount_type', '!=', '')->latest('id')->get();
            if (isset($vehicles))
                $vehicles->each(function ($item) {
                    $item->is_mowater_card = false;
                });
            // items not in mowater card and have offers end

            // items have mowater card start
            $mowater_vehicles = $rental_office->rental_office_cars()->wherehas('offers')->latest('id')->get();

            if (isset($mowater_vehicles)) {
                rentalVehicleOffers($mowater_vehicles);
            }
            // items have mowater card end

            //merge all results in one array
            $merged =collect(GetRentalCarsOffersResource::collection($vehicles))
                ->merge(GetRentalCarsOffersResource::collection($mowater_vehicles))->paginate(PAGINATION_COUNT);

            return responseJson(1, 'success', $merged);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function reservation(RentalReservationRequest $request)
    {
        // auth user
        $user = getAuthAPIUser();

        $validator = $request->except(['personal_ID_for_rental','driving_license_for_rental','barcode']);
        $validator['user_id'] = $user->id;
        $rental_office_car = RentalOfficeCar::find($request->rental_office_car_id);
        $rental_office = RentalOffice::find($rental_office_car->rental_office_id);

        if ($rental_office_car->available == 0)
            return responseJson(0, 'error', __('message.vehicle_not_available_for_reservation'));
        if ($rental_office->reservation_availability == 0)
            return responseJson(0, 'error', __('message.reservation_not_available'));
        if ($rental_office->reservation_active == 0)
            return responseJson(0, 'error', __('message.reservation_not_active'));

        $rental_offers = $rental_office->rental_office_cars()->wherehas('offers')->pluck('id')->toArray();

        // use mawater card start
        if ($request->is_mawater_card == true) {
            $user_mawater_card_vehicles = $user->discount_cards()->wherePivot('barcode', $request->barcode)->first();
            $car = $request->rental_office_car_id;

            try {
                DB::beginTransaction();
                        if (in_array($car, $rental_offers)) {
                            $rental_offer = Offer::where('offerable_id',$car)
                                ->where('offerable_type', 'App\\Models\\RentalOfficeCar')->first();

                            $consumption = DiscoutnCardUserUse::where('barcode', $request->barcode)
                                ->where('offer_id', $rental_offer->id)->first();
                            if (!$consumption) {
                                DiscoutnCardUserUse::create([
                                    'user_id' => $user,
                                    'barcode' => $request->barcode,
                                    'offer_id' => $rental_offer->id,
                                    'original_number_of_uses' => $rental_offer->specific_number,
                                    'consumption_number' => 1
                                ]);
                            } else {
                                if ($consumption->consumption_number == $consumption->original_number_of_uses) {
                                    return responseJson(0, 'error', 'you have reach max number of consumption for product id: ' . $car);
                                }
                                $consumption->update([
                                    'consumption_number' => $consumption->consumption_number + 1
                                ]);
                            }
                        } else {
                            return responseJson(0, 'error', __('message.vehicle_id') . $car . __('message.service_not_fount_in_offer'));
                        }


                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return responseJson(0, 'error', $e->getMessage());
            }

        }
        // use mawater card end

        $reservation = RentalReservation::create($validator);
        $rental_reservation = $reservation->refresh();
        $rental_reservation->upload_reserve_vehicle_images();
        return responseJson(1, 'success', $reservation);
    }

    public function get_user_reservations()
    {
        $user = auth('api')->user()->id;
        $reservations = RentalReservation::with('rental_office_car')->where('user_id', $user)->latest('id')->paginate(PAGINATION_COUNT);
        if ($reservations)
            return responseJson(1, 'success', ShowUserRentalReservationResource::collection($reservations)->response()->getData(true));
        return responseJson(0, __('message.no_reservations_found_for_this_user'));
    }

    public function show_reservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:rental_reservations,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors());
        } else {
            $reservation = RentalReservation::with('rental_office_car', 'user')->find($request->id);
            if (empty($reservation))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', new ShowUserRentalReservationResource($reservation));
        }
    }

}
