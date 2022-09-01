<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DeliveryManAvailableTimeRequest;
use App\Http\Requests\API\ReserveDeliveryManRequest;
use App\Http\Requests\API\ShowDeliveryManRequest;
use App\Http\Requests\API\ShowDeliveryReservationRequest;
use App\Http\Resources\Categories\GetCategoriesResource;
use App\Http\Resources\Delivery\GetDeliveriesResource;
use App\Http\Resources\Delivery\GetDeliveryMawaterCardOffersResource;
use App\Http\Resources\Delivery\GetReservationResource;
use App\Http\Resources\Trainers\GetMawaterOffersResource;
use App\Models\Category;
use App\Models\DeliveryMan;
use App\Models\DeliveryManCategory;
use App\Models\DeliveryManReservation;
use App\Models\DiscoutnCardUserUse;
use App\Models\DrivingTrainerType;
use App\Models\Offer;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DeliveryManController extends Controller
{
    public function index()
    {
        try {
            $men = DeliveryMan::search()->active()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($men))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetDeliveriesResource::collection($men)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson("0", "error", $e->getMessage());
        }
    }

    public function show_delivery_man(ShowDeliveryManRequest $request)
    {
        try {
            $man = DeliveryMan::find($request->id);
            if (empty($man))
                return responseJson(0,__('message.no_result'));
            //update number of views start
            updateNumberOfViews($man);
            //update number of views end

            return responseJson(1, 'success', new GetDeliveriesResource($man));
        } catch (\Exception $e) {
            return responseJson("0", "error", $e->getMessage());
        }
    }

    public function delivery_man_available_times(DeliveryManAvailableTimeRequest $request)
    {
        try {
            $day = date("D", strtotime($request->date));

            if (date('Y-m-d', strtotime($request->date)) <= \Carbon\Carbon::yesterday()->format('Y-m-d')) {
                return responseJson(0, __('message.requested_date') . $request->date . ' ' . __('message.date_is_old'));
            }
            $man = DeliveryMan::with(['work_time', 'day_offs'])->find($request->id);
            $date = explode('-', $request->date);
            $check = checkdate($date[1], $date[2], $date[0]);
            if ($check) {
                $day_offs = $man->day_offs()->where('date', $request->date)->get();
                foreach ($day_offs as $day_off) {
                    if ($day_off)
                        return responseJson(0, __('message.requested_date') . $request->date . __('message.is_day_off'));
                }
                $find_day = in_array($day, $man->work_time->days);
                if ($find_day !== false) {

                    $module = $man->work_time;
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

                        $reservations = $man->reservations;

                        if (isset($reservations)) {
                            foreach ($reservations as $key => $reservation) {
                                $day_to_go = date("Y-m-d", strtotime($reservation->day_to_go));
                                $day_t_return = date("Y-m-d", strtotime($reservation->day_t_return));
                                if ($request->date == $day_to_go || $request->date == $day_t_return) {
                                    return responseJson(0, __('message.requested_date') . $request->date . __('message.date_is_not_available'));
                                }
                                if ($reservation->date == $request->date) {
                                    $formated = date("h:i a", strtotime($reservation->time));
                                    if (($key = array_search($formated, $available_times)) !== false) {
                                        unset($available_times[$key]);
                                    }
                                }
                            }
                        }
                    }
                    return responseJson(1, 'success', array_values($available_times));
                } else {
                    return responseJson(0, __('message.requested_date') . $request->date . __('message.is_day_off'));
                }
            } else {
                return responseJson(0, __('message.date_is_not_found') . $request->date);

            }
        } catch (\Exception $e) {
            return responseJson(0, 'error');
        }
    }

    public function delivery_types()
    {
        $section = Section::where('ref_name', 'DeliveryMan')->pluck('id');
        $types = Category::where('section_id', $section)->get();
        if (empty($types))
            return responseJson(0,__('message.no_result'));
        return responseJson(1, 'success', GetCategoriesResource::collection($types));
    }

    public function reserve_delivery(ReserveDeliveryManRequest $request)
    {
        try {
            $user = getAuthAPIUser();

            $id = $request->delivery_man_id;
            $date = $request->day_to_go;

            $man = DeliveryMan::find($id);

            $request['day_to_go'] = date('Y-m-d H:i:s', strtotime($date));

            $request['user_id'] = $user->id;
            $request_data = $request->except(['is_mawater_card', 'barcode']);
            if ($man->active == 0)
                return responseJson(0, 'error', __('message.not_active'));
            if ($man->available == 0)
                return responseJson(0, 'error', __('message.not_available'));

            $reservations = $man->reservations;
            foreach ($reservations as $reservation) {
                if ($reservation->day_to_go == $date)
                    return responseJson(0, 'error', __('message.this_time_is_reserved'));
            }

            // use mawater card start
            if ($request->is_mawater_card == true) {

                try {
                    DB::beginTransaction();
                    $type = DeliveryManCategory::where('delivery_man_id', $request->delivery_man_id)
                        ->where('category_id', $request->category_id)->whereHas('offers')->first();
                    $offer = Offer::where('offerable_id', $type->id)
                        ->where('offerable_type', 'App\\Models\\DeliveryManCategory')->first();

                    $offer_consumption = DiscoutnCardUserUse::where('barcode', $request->barcode)
                        ->where('offer_id', $offer->id)->first();
                    if (!$offer_consumption) {
                        DiscoutnCardUserUse::create([
                            'user_id' => $user->id,
                            'barcode' => $request->barcode,
                            'offer_id' => $offer->id,
                            'original_number_of_uses' => $offer->specific_number,
                            'consumption_number' => 1
                        ]);
                    } else {
                        if ($offer_consumption->consumption_number == $offer_consumption->original_number_of_uses) {
                            return responseJson(0, 'error', 'you have reach max number of consumption for service id: ');
                        }
                        $offer_consumption->update([
                            'consumption_number' => $offer_consumption->consumption_number + 1
                        ]);
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return responseJson(0, 'error', $e->getMessage());
                }

            }
            // use mawater card end

            $reserve = $man->reservations()->create($request_data);
            if ($reserve)
                return responseJson(1, 'success', new GetReservationResource($reserve));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUserReservations()
    {
        try {
            $user = getAuthAPIUser();

            $reservations = $user->delivery_reservations()->paginate(PAGINATION_COUNT);

            if (empty($reservations))
                return responseJson(0,__('message.no_result'));

            return responseJson(1, 'success', GetReservationResource::collection($reservations)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function showUserReservation(ShowDeliveryReservationRequest $request)
    {
        try {
            $user = getAuthAPIUser();

            $reservation = DeliveryManReservation::find($request->id);

            if (empty($reservation))
                return responseJson(0,__('message.no_result'));

            return responseJson(1, 'success', new GetReservationResource($reservation));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getDiscountCardOffers(ShowDeliveryManRequest $request)
    {
        $man = DeliveryMan::active()->find($request->id);

        $discount_cards = $man->discount_cards()->where('status', 'started')->get();

        if (!$discount_cards->isEmpty()) {

            $types = DeliveryManCategory::where('delivery_man_id', $request->id)->whereHas('offers')->paginate(PAGINATION_COUNT);
            if (empty($types))
                return responseJson(0,__('message.no_result'));
            foreach ($types as $type) {
                foreach ($type->offers as $offer) {
                    $discount_type = $offer->discount_type;
                    $percentage_value = ((100 - $offer->discount_value) / 100);
                    if ($discount_type == 'percentage') {
                        $price_after_discount = $type->price * $percentage_value;
                        $type->card_discount_value = $offer->discount_value . '%';
                        $type->card_price_after_discount = $price_after_discount . ' BHD';
                        $type->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                    } else {
                        $price_after_discount = $type->price - $offer->discount_value;
                        $type->card_discount_value = $offer->discount_value . ' BHD';
                        $type->card_price_after_discount = $price_after_discount . ' BHD';
                        $type->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                    }
                    $type->notes = $offer->notes;
                    $type->makeHidden('offers');
                }
            }

            return responseJson(1, 'success', GetDeliveryMawaterCardOffersResource::collection($types)->response()->getData(true));

        } else {
            return responseJson(0, 'error', __('message.something_wrong'));
        }

    }
}
