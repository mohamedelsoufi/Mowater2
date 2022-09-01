<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DrivingTrainerAvailableTimeRequest;
use App\Http\Requests\API\DrivingTrainerRequest;
use App\Http\Requests\API\ReserveDrivingTrainerRequest;
use App\Http\Requests\API\ShowDrivingReservationRequest;
use App\Http\Resources\Trainers\GetMawaterOffersResource;
use App\Http\Resources\Trainers\GetTrainersResource;
use App\Http\Resources\Trainers\ReservationsResource;
use App\Http\Resources\Trainers\TrainigTypesResource;
use App\Models\Country;
use App\Models\DiscoutnCardUserUse;
use App\Models\DrivingTrainer;
use App\Models\DrivingTrainerType;
use App\Models\Offer;
use App\Models\Section;
use App\Models\TrainingReservation;
use App\Models\TrainingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class DrivingTrainerController extends Controller
{
    public function index()
    {
        try {
            $trainers = DrivingTrainer::search()->active()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($trainers))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetTrainersResource::collection($trainers)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show_trainer(DrivingTrainerRequest $request)
    {
        try {
            $trainer = DrivingTrainer::find($request->trainer_id);
            if (empty($trainer))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($trainer);
            //update number of views end

            return responseJson(1, 'success', new GetTrainersResource($trainer));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function trainer_available_times(DrivingTrainerAvailableTimeRequest $request)
    {
        try {
            $day = date("D", strtotime($request->date));
            if (date('Y-m-d', strtotime($request->date)) <= \Carbon\Carbon::yesterday()->format('Y-m-d')) {
                return responseJson(0, __('message.requested_date') . $request->date . ' ' . __('message.date_is_old'));
            }

            $trainer = DrivingTrainer::with(['work_time', 'day_offs'])->find($request->id);
            $date = explode('-', $request->date);
            $check = checkdate($date[1], $date[2], $date[0]);
            if ($check) {
                if (isset($trainer->day_offs)) {
                    $day_offs = $trainer->day_offs()->where('date', $request->date)->get();
                    foreach ($day_offs as $day_off) {
                        if ($day_off)
                            return responseJson(0, __('message.requested_date') . $request->date . __('message.is_day_off'));
                    }
                }
                $find_day = in_array($day, $trainer->work_time->days);
                if ($find_day !== false) {

                    $module = $trainer->work_time;

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

                        $reservations = $trainer->reservations;
                        foreach ($reservations as $key => $reservation) {
                            foreach ($reservation->reservation_sessions as $session) {
                                if ($session->date == $request->date) {
                                    $formated = date("h:i a", strtotime($session->time));
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
                return responseJson(0, __('message.requested_date') . $request->date . ' ' . __('message.date_is_not_found'));

            }
        } catch (\Exception $e) {
            return responseJson(0, __('message.requested_date') . $request->date . __('message.is_day_off'));
        }
    }

    public function training_types()
    {
        try {
            $types = TrainingType::all();
            if (empty($types))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', TrainigTypesResource::collection($types));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function reserve_training(ReserveDrivingTrainerRequest $request)
    {
        try {
            $user = getAuthAPIUser();
            $request['user_id'] = $user->id;
            $request['date'] = date("d-m-y", strtotime($request->date));
            $trainer = DrivingTrainer::find($request->driving_trainer_id);
            $no_of_hours = TrainingType::find($request->training_type_id)->no_of_hours;
            $hour_price = $hour_price = Section::where('ref_name', 'DrivingTrainer')->first()->reservation_cost;
            $training_type_sessions = $no_of_hours / 2;
            $times = $request->sessions;
            $found_times = [];
            if (count($times) == $training_type_sessions) {
                foreach ($times as $time) {
                    if (Arr::has($time, 'time') && Arr::has($time, 'date')) {
                        $date = explode('-', $time['date']);
                        $check = checkdate($date[1], $date[2], $date[0]);
                        if ($check) {
                            if (strtotime($time['date']) < strtotime('now')) {
                                return responseJson(0, __('message.requested_date') . $time['date'] . ' ' . __('message.date_is_old'));
                            }
                            $request['id'] = $trainer->id;
                            $request['date'] = $time['date'];
                            $available_times = $trainer->available_reservation($request);
                            $flag = 0;
                            $count = count($available_times);
                            if (count($available_times) > 0) {
                                foreach ($available_times as $key => $available_time) {
                                    if ($available_time == $time['time']) {
                                        $flag = 1; //found
                                        if (count($found_times) > 0) {
                                            foreach ($found_times as $key => $found_time) {
                                                if ($found_time['date'] == $time['date'] && $found_time['time'] == $time['time']) {
                                                    return responseJson(1, 'error', __('message.dates_are_repeated'));
                                                }
                                            }
                                        }
                                        unset($available_times[$key]);
                                        $found_times[$key]['date'] = $time['date'];
                                        $found_times[$key]['time'] = $time['time'];
                                    }
                                }
                                if ($flag != 1) {
                                    return responseJson(0, $time['date'] . ":" . $time['time'] . " " . __('message.time_not_available'));
                                }
                            } else {
                                return responseJson(0, __('message.is_day_off') . $time['date']);
                            }
                        }
                    } else {
                        return responseJson(0, __('message.this_times_is_not_suitable_with_training_type') . $training_type_sessions . ' dates and times');

                    }
                }
                $price = $no_of_hours * $hour_price;
                if ($trainer->active == 0)
                    return responseJson(0, 'error', __('message.not_active'));
                if ($trainer->available == 0)
                    return responseJson(0, 'error', __('message.not_available'));


                // use mawater card start
                if ($request->is_mawater_card == true) {

                    try {
                        DB::beginTransaction();
                        $type = DrivingTrainerType::where('driving_trainer_id', $request->driving_trainer_id)
                            ->where('training_type_id', $request->training_type_id)->whereHas('offers')->first();
                        $offer = Offer::where('offerable_id', $type->id)
                            ->where('offerable_type', 'App\\Models\\DrivingTrainerType')->first();

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


                $reservation = $trainer->reservations()->create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'nickname' => $request->nickname,
                    'country_code' => $request->country_code,
                    'phone' => $request->phone,
                    'age' => $request->age,
                    'is_previous_license' => $request->is_previous_license,
                    'attended_the_theoretical_driving_training_session' => $request->attended_the_theoretical_driving_training_session,
                    'training_type_id' => $request->training_type_id,
                    'user_id' => $request['user_id'],
                    'price' => $price
                ]);
                //loop on times of reservation
                foreach ($times as $time) {
                    $reservation_sessions = $reservation->reservation_sessions()->create(['time' => date('H:i:s', strtotime($time['time'])),
                        'date' => $time['date'],]);
                }
                if ($reservation)
                    return responseJson(1, 'success', new ReservationsResource($reservation));
            } else {
                return responseJson(0, 'your times are not suitable with the training type you chose,you should enter :' . $training_type_sessions . ' dates and times');
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUserReservations()
    {
        try {
            $user = getAuthAPIUser();

            $reservations = $user->training_reservations()->paginate(PAGINATION_COUNT);

            if (empty($reservations))
                return responseJson(0, __('message.no_result'));

            return responseJson(1, 'success', ReservationsResource::collection($reservations)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function showUserReservation(ShowDrivingReservationRequest $request)
    {
        try {
            $user = getAuthAPIUser();

            $reservation = TrainingReservation::find($request->id);
            if (empty($reservation))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', new ReservationsResource($reservation));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getDiscountCardOffers(DrivingTrainerRequest $request)
    {
        $trainer = DrivingTrainer::active()->find($request->trainer_id);

        $discount_cards = $trainer->discount_cards()->where('status', 'started')->get();

        if (!$discount_cards->isEmpty()) {

            $types = DrivingTrainerType::where('driving_trainer_id', $request->trainer_id)->whereHas('offers')->paginate(PAGINATION_COUNT);

            if (empty($types))
                return responseJson(0, __('message.no_result'));

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

            return responseJson(1, 'success', GetMawaterOffersResource::collection($types)->response()->getData(true));

        } else {
            return responseJson(0, 'error', __('message.something_wrong'));
        }

    }
}
