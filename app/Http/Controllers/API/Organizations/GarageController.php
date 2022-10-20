<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\BranchReservationRequest;
use App\Http\Requests\API\ShowGarageRequest;
use App\Http\Requests\API\ShowReservationRequest;
use App\Http\Resources\Garages\GetGarageProductsResource;
use App\Http\Resources\Garages\GetGarageServicesResource;
use App\Http\Resources\Garages\GetGaragesResource;
use App\Http\Resources\Garages\ShowGarageResource;
use App\Http\Resources\Wenches\UserReservationsResource;
use App\Models\DiscoutnCardUserUse;
use App\Models\Garage;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GarageController extends Controller
{

    public function index()
    {
        try {
            $garages = Garage::active()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($garages))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetGaragesResource::collection($garages)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowGarageRequest $request)
    {
        try {
            $garage = Garage::active()->find($request->id);
            if (empty($garage))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($garage);
            //update number of views end

            return responseJson(1, 'success', new ShowGarageResource($garage));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function get_products(ShowGarageRequest $request)
    {
        try {
            $garage = Garage::active()->find($request->id);

            $products = $garage->products()->active()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($products))
                return responseJson(0, __('message.no_result'));
            if ($products->count() == 0)
                return responseJson(0, __('message.no_products_for_this_garage'));
            return responseJson(1, 'success', GetGarageProductsResource::collection($products)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function get_services(ShowGarageRequest $request)
    {
        try {
            $garage = Garage::active()->find($request->id);

            $services = $garage->services()->active()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($services))
                return responseJson(0, __('message.no_result'));
            if ($services->count() == 0)
                return responseJson(0, __('message.no_services_for_this_garage'));
            return responseJson(1, 'success', GetGarageServicesResource::collection($services)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function available_times(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:garages,id',
                'date' => 'required|date'
            ]);
            if ($validator->fails())
                return responseJson(0, $validator->errors()->first(), $validator->errors());
            $day = date("D", strtotime($request->date));

            $garage = Garage::with(['work_time', 'day_offs'])->find($request->id);


            $day_offs = $garage->day_offs()->where('date', $request->date)->get();
            foreach ($day_offs as $day_off) {
                if ($day_off)
                    return responseJson(0, __('message.requested_date' . $request->date) . __('message.is_day_off'));
            }
            if (!$garage->work_time) {
                return responseJson(0, __('message.no_work_times_for_this_garage'));
            }
            $find_day = array_search($day, $garage->work_time->days);


            if ($find_day !== false) {

                $module = $garage->work_time;

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

                    $reservations = $garage->reservations;
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
            return responseJson(0, 'error');
        }
    }

    public function reservations(BranchReservationRequest $request)
    {
        try {
//            $class = 'App\\Models\\' . $request->reservable_type;
//            $model = new $class;
            $id = $request->reservable_id;
            $date = $request->date;
            $time = $request->time;

            $record = Garage::with(['day_offs'])->find($id); // $record = Product::find(1);

            $auth_user = getAuthAPIUser();

            if ($request->has('services') || $request->has('products')) {

                if ($record) {
                    if ($record->reservation_active == 0)
                        return responseJson(0, 'error', __('message.reservation_not_active'));

                    if ($record->reservation_availability == true) {

                        $user = $auth_user->id;

                        $validator = $request->except('services', 'products');
                        $validator['user_id'] = $user;

                        $product_offers = $record->products()->wherehas('offers')->pluck('id')->toArray();
                        $service_offers = $record->services()->wherehas('offers')->pluck('id')->toArray();

                        // use mawater card start
                        if ($request->is_mawater_card == true) {
                            $user_mawater_card_vehicles = $auth_user->discount_cards()->wherePivot('barcode', $request->barcode)->first();

                            $user_dc_vehicles = $user_mawater_card_vehicles->pivot->vehicles;
                            $user_dc_vehicles_array = explode(',', $user_dc_vehicles);
                            foreach ($request->owen_vehicles as $vehicle) {
                                if (!in_array($vehicle['id'], $user_dc_vehicles_array)) {
                                    return responseJson(0, 'error', __('message.user_vehicle_not_found'));
                                }
                            }

                            try {
                                DB::beginTransaction();
                                if ($request->has('products')) {
                                    foreach ($request->products as $product) {
                                        if (in_array($product['id'], $product_offers)) {
                                            $product_offer = Offer::where('offerable_id', $product['id'])
                                                ->where('offerable_type', 'App\\Models\\Product')->first();

                                            $consumption = DiscoutnCardUserUse::where('barcode', $request->barcode)
                                                ->where('offer_id', $product_offer->id)->first();
                                            if (!$consumption) {
                                                DiscoutnCardUserUse::create([
                                                    'user_id' => $user,
                                                    'barcode' => $request->barcode,
                                                    'offer_id' => $product_offer->id,
                                                    'original_number_of_uses' => $product_offer->specific_number,
                                                    'consumption_number' => 1
                                                ]);
                                            } else {
                                                if ($consumption->consumption_number == $consumption->original_number_of_uses) {
                                                    return responseJson(0, 'error', 'you have reach max number of consumption for product id: ' . $product['id']);
                                                }
                                                $consumption->update([
                                                    'consumption_number' => $consumption->consumption_number + 1
                                                ]);
                                            }
                                        } else {
                                            return responseJson(0, 'error', __('message.product_id') . $product['id'] . __('message.service_not_fount_in_offer'));
                                        }
                                    }
                                }

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

                        DB::beginTransaction();
                        $reservation = $record->reservations()->create($validator);

                        if ($request->has('services')) {
                            foreach ($request->services as $service) {
                                $service_model = $record->services()->find($service);
                                if (!$service_model)
                                    return responseJson(0, 'error', __('message.Service_id') . ' ' . $service . ' ' . __('message.not_exist'));
                                if ($service_model->available == 0 || $service_model->active == 0) {
                                    return responseJson(0, __('message.Service_id') . $service_model->id . __('message.not_available_or_not_active'));
                                }
                                $service_available_times = [];
                                if ($service_model->work_time)
                                    $service_available_times = service_available_reservation($id, $date, $service, $record);
                                if (in_array(date("h:i a", strtotime($time)), $service_available_times) || !$service_model->work_time) {
//                                    return $request->services;
                                    $reservation->services()->attach($service);

                                } else {
                                    DB::rollBack();
                                    return responseJson(0, 'error', __('message.this_time_is_not_available_for_services') . __('message.Service_id') . $service);
                                }
                            }
                        }

                        if ($request->has('products')) {
                            foreach ($request->products as $product) {
                                $product_model = $record->products()->find($product['id']);
                                if (!$product_model)
                                    return responseJson(0, 'error', __('message.product_id') . ' ' . $product['id'] . ' ' . __('message.not_exist'));
                                if ($product_model->available == 0 || $product_model->active == 0) {
                                    DB::rollBack();
                                    return responseJson(0, __('message.product_id') . $product_model->id . __('message.not_available_or_not_active'));
                                } else {
                                    $reservation->products()->attach($product['id'], [
                                        'quantity' => $product['quantity']
                                    ]);
                                }
                            }
                        }
                        DB::commit();
                        return responseJson(1, 'success', $reservation);

                    } else {
                        return responseJson(0, __('message.not_available_or_not_active'));
                    }
                }
                return responseJson(0, __('message.no_result'));
            }
            return responseJson(0, __('message.please_make_reservation_at_least_one'));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUserReservations()
    {
        try {
            $reservations = userReservations("App\\Models\\Garage");
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
            $reservation = userReservation("App\\Models\\Garage");
            if (empty($reservation))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', new UserReservationsResource($reservation));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getDiscountCardOffers(ShowGarageRequest $request)
    {
        $garage = Garage::selection()->active()->find($request->id);

        $discount_cards = $garage->discount_cards()->where('status', 'started')->get();

        if (!$discount_cards->isEmpty()) {
            $products = $garage->products()->wherehas('offers')->get();

            $services = $garage->services()->wherehas('offers')->get();

            foreach ($products as $product) {
                $product->kind = 'product';
                foreach ($product->offers as $offer) {
                    $discount_type = $offer->discount_type;
                    $percentage_value = ((100 - $offer->discount_value) / 100);
                    if ($discount_type == 'percentage') {
                        $price_after_discount = $product->price * $percentage_value;
                        $product->card_discount_value = $offer->discount_value . '%';
                        $product->card_price_after_discount = $price_after_discount . ' BHD';
                        $product->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                    } else {
                        $price_after_discount = $product->price - $offer->discount_value;
                        $product->card_discount_value = $offer->discount_value . ' BHD';
                        $product->card_price_after_discount = $price_after_discount . ' BHD';
                        $product->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                    }
                    $product->notes = $offer->notes;
                    $product->makeHidden('offers');
                }
            }

            foreach ($services as $service) {
                $service->kind = 'service';
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
                    $service->makeHidden('offers');
                }
            }
            $merged = collect($products)->merge($services)->paginate(PAGINATION_COUNT);
            if (empty($merged))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', $merged);
//            return responseJson(1, 'success', ['products' => $products, 'services' => $services]);

        } else {
            return responseJson(0, 'error', __('message.something_wrong'));
        }

    }
}
