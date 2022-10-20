<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\NearestLocationRequest;
use App\Http\Requests\API\ReserveWenchRequest;
use App\Http\Requests\API\ShowReservationRequest;
use App\Http\Requests\API\ShowWenchRequest;
use App\Http\Resources\Wenches\GetNearestResource;
use App\Http\Resources\Wenches\GetServicesResource;
use App\Http\Resources\Wenches\GetWenchesResource;
use App\Http\Resources\Wenches\ShowWenchResource;
use App\Http\Resources\Wenches\UserReservationsResource;
use App\Models\DiscoutnCardUserUse;
use App\Models\Offer;
use App\Models\RentalOffice;
use App\Models\Wench;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WenchController extends Controller
{

    public function index()
    {
        try {
            $wenches = Wench::with(['country', 'city', 'area'])->active()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($wenches))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetWenchesResource::collection($wenches)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowWenchRequest $request)
    {
        try {
            $wench = Wench::active()->find($request->id);
            if (empty($wench))
                return responseJson(0, __('message.no_result'));
//            return$wench->services;
            //update number of views start
            updateNumberOfViews($wench);
            //update number of views end

            return responseJson(1, 'success', new ShowWenchResource($wench));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function available_times(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:wenches,id',
                'date' => 'required|date'
            ]);
            if ($validator->fails())
                return responseJson(0, $validator->errors()->first(), $validator->errors());
            $day = date("D", strtotime($request->date));

            $wench = Wench::with(['work_time', 'day_offs'])->find($request->id);


            $day_offs = $wench->day_offs()->where('date', $request->date)->get();
            foreach ($day_offs as $day_off) {
                if ($day_off)
                    return responseJson(0, __('message.requested_date') . $request->date . __('message.is_day_off'));
            }
            if (!$wench->work_time) {
                return responseJson(0, __('message.no_work_times_for_this_wench'));
            }
            $find_day = array_search($day, $wench->work_time->days);


            if ($find_day !== false) {

                $module = $wench->work_time;

                $available_times = [];

                $from = date("H:i", strtotime($module->from));
                $to = date("H:i", strtotime($module->to));


                if (!in_array(date("h:i a", strtotime($from)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($from)));
                }

                $time_from = strtotime($from);

                $new_time = date("H:i", strtotime($module->duration . ' minutes', $time_from));
                if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($new_time)));
                }

                while ($new_time < $to) {
                    $time = strtotime($new_time);
                    $new_time = date("H:i", strtotime($module->duration . ' minutes', $time));
                    if ($new_time . ':00' >= $to) {
                        break;
                    }

                    if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                        array_push($available_times, date("h:i a", strtotime($new_time)));
                    }

                    $reservations = $wench->reservations;
                    foreach ($reservations as $key => $reservation) {
                        if ($reservation->date == $request->date) {
                            $formated = date("h:i a", strtotime($reservation->time));

                            if (($key = array_search($formated, $available_times)) !== false) {
                                unset($available_times[$key]);
                            }
                        }
                    }
                }

                return responseJson(1, 'success', array_values($available_times));
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error : ' . $e->getMessage());
        }
    }

    public function reservations(ReserveWenchRequest $request)
    {
        try {
            $wench = Wench::active()->find($request->id);

            if ($wench) {

                if ($wench->reservation_active == 0)
                    return responseJson(0, 'error', __('message.reservation_not_active'));

                if ($wench->reservation_availability == true) {

                    $user = getAuthAPIUser();
                    $validator = $request->except(['barcode', 'services', 'id']);
                    $validator['user_id'] = $user->id;
                    $validator['reservable_type'] = 'Wench';
                    $validator['reservable_id'] = $request->id;

                    // use mawater card start
                    if ($request->is_mawater_card == true) {
                        $service_offers = $wench->services()->wherehas('offers')->pluck('id')->toArray();


                        $user_mawater_card_vehicles = $user->discount_cards()->wherePivot('barcode', $request->barcode)->first();

                        $user_dc_vehicles = $user_mawater_card_vehicles->pivot->vehicles;
                        $user_dc_vehicles_array = explode(',', $user_dc_vehicles);
                        foreach ($request->owen_vehicles as $vehicle) {
                            if (!in_array($vehicle['id'], $user_dc_vehicles_array)) {
                                return responseJson(0, 'error', __('message.user_vehicle_not_found'));
                            }
                        }

                        try {
                            DB::beginTransaction();

                            if ($request->has('services')) {
                                foreach ($request->services as $service) {
                                    if (in_array($service, $service_offers)) {
                                        $service_offer = Offer::where('offerable_id', $service)
                                            ->where('offerable_type', 'App\\Models\\Service')->first();

                                        $service_consumption = DiscoutnCardUserUse::where('barcode', $request->barcode)
                                            ->where('offer_id', $service_offer->id)->first();
                                        if (!$service_consumption) {
                                            DiscoutnCardUserUse::create([
                                                'user_id' => $user,
                                                'barcode' => $request->barcode,
                                                'offer_id' => $service_offer->id,
                                                'original_number_of_uses' => $service_offer->specific_number,
                                                'consumption_number' => 1
                                            ]);
                                        } else {
                                            if ($service_consumption->consumption_number == $service_consumption->original_number_of_uses) {
                                                return responseJson(0, 'error', 'you have reach max number of consumption for service id: ' . $service);
                                            }
                                            $service_consumption->update([
                                                'consumption_number' => $service_consumption->consumption_number + 1
                                            ]);
                                        }
                                    } else {
                                        return responseJson(0, 'error', __('message.Service_id') . $service . __('message.service_not_fount_in_offer'));
                                    }
                                }
                            }
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                            return responseJson(0, 'error', $e->getMessage());
                        }

                    }
                    // use mawater card end

                    $reservation = $wench->reservations()->create($validator);


                    foreach ($request->services as $service) {
                        $service_model = $wench->services()->find($service);
                        if (!$service_model)
                            return responseJson(0, 'error', __('message.Service_id') . ' ' . $service . ' ' . __('message.not_exist'));
                        if ($service_model->available == 0 || $service_model->active == 0) {
                            return responseJson(0, __('message.Service_id') . $service_model->id . __('message.not_available_or_not_active'));
                        }
                    }
                    $reservation->services()->attach($request->services);


                    return responseJson(1, 'success', $reservation);
                }

                return responseJson(0, __('message.reservation_not_available'));
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function get_services(ShowWenchRequest $request)
    {
        try {
            $wench = Wench::active()->find($request->id);

            $services = $wench->services()->active()->latest('id')->paginate(PAGINATION_COUNT);
            if ($services->count() == 0)
                return responseJson(0, __('message.no_services_for_this_wench'));

            return responseJson(1, 'success', GetServicesResource::collection($services)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function nearest_location(NearestLocationRequest $request)
    {
        try {
            $data = getNearestLocation("wenches")->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetNearestResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUserReservations()
    {
        try {

            $reservations =userReservations("App\\Models\\Wench");
            if (empty($reservations))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', UserReservationsResource::collection($reservations)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowUserReservation(ShowReservationRequest $request)
    {
        try {
            getAuthAPIUser();
            $reservation =userReservation("App\\Models\\Wench");
            if (empty($reservation))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', new UserReservationsResource($reservation));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getDiscountCardOffers(ShowWenchRequest $request)
    {
        $wench = Wench::selection()->active()->find($request->id);

        $discount_cards = $wench->discount_cards()->where('status', 'started')->get();

        if (!$discount_cards->isEmpty()) {

            $services = $wench->services()->wherehas('offers')->paginate(PAGINATION_COUNT);
            if (empty($services))
                return responseJson(0, __('message.no_result'));
            foreach ($services as $service) {
                foreach ($service->offers as $offer) {
                    $discount_type = $offer->discount_type;
                    $percentage_value = ((100 - $offer->discount_value) / 100);
                    if ($discount_type == 'percentage') {
                        $price_after_discount = $service->price * $percentage_value;
                        $service->card_discount_value = $offer->discount_value . '%';
                        $service->card_price_after_discount = $price_after_discount . ' BHD';
                        $service->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                    } else {
                        $price_after_discount = $service->price - $offer->discount_value;
                        $service->card_discount_value = $offer->discount_value . ' BHD';
                        $service->card_price_after_discount = $price_after_discount . ' BHD';
                        $service->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                    }
                    $service->notes = $offer->notes;
                    $service->makeHidden('offers');
                }
            }

            return responseJson(1, 'success',  $services);

        } else {
            return responseJson(0, 'error', __('message.something_wrong'));
        }

    }
}
