<?php


namespace App\Repositories\TechnicalInspectionCenter;


use App\Http\Resources\TechnicalInspectionCenter\RequestInspectionCenterResource;
use App\Models\DiscoutnCardUserUse;
use App\Models\Offer;
use App\Models\TechnicalInspectionCenter;
use App\Models\TechnicalInspectionCenterService;
use Illuminate\Support\Facades\DB;

class TechnicalInspectionCenterRepository implements TechnicalInspectionCenterInterface
{
    protected $model;
    protected $service;

    public function __construct(TechnicalInspectionCenter $model, TechnicalInspectionCenterService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }

    public function getAll()
    {
        try {
            $centers = $this->model->search()->latest('id');
            return $centers;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getCenterById($request)
    {
        try {
            $center = $this->model->where('id', $request);
            return $center;

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function mawaterOffers($request)
    {
        try {
            $center = $this->model->find($request);

            $discount_cards = $center->discount_cards()->where('status', 'started')->get();

            if ($discount_cards->isEmpty()) {
                return responseJson(0, 'error', __('message.something_wrong'));
            }
            $services = $center->inspectionCenterService()->whereHas('offers')->get();

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
            return $services;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getServices()
    {
        try {
            $services = $this->service->latest('id');
            return $services;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function showService($request)
    {
        try {
            $service = $this->service->where('id', $request);
            return $service;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ServiceAvailableTimes($request)
    {
        try {
            return $data = $this->service->inspection_service_available_reservation($request->date, $request->id, $this->model, $this->service, $request->service);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function requestTechnicalInspection($request)
    {
        try {
            $user = getAuthAPIUser();
            $request['user_id'] = $user->id;
            $center = $this->getCenterById($request->technical_inspection_center_id)->first();


            if ($center->reservation_active == 0)
                return responseJson(0, 'error', __('message.reservation_not_active'));

            if ($center->reservation_availability == true) {
                // use mawater card start
                if ($request->is_mawater_card == true) {
                    $service_offers = $center->inspectionCenterService()->whereHas('offers')->pluck('id')->toArray();

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
                        foreach ($request->services as $service) {
                            if (in_array($service, $service_offers)) {
                                $service_offer = Offer::where('offerable_id', $service)
                                    ->where('offerable_type', 'App\\Models\\TechnicalInspectionCenterService')->first();

                                $service_consumption = DiscoutnCardUserUse::where('barcode', $request->barcode)
                                    ->where('offer_id', $service_offer->id)->first();
                                if (!$service_consumption) {
                                    DiscoutnCardUserUse::create([
                                        'user_id' => $user->id,
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

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return responseJson(0, 'error', $e->getMessage());
                    }

                }
                // use mawater card end

                DB::beginTransaction();
                $request_inspection = $center->inspectionRequests()->create($request->except('services'));

                foreach ($request->services as $service) {
                    $service_model = $this->service->find($service);
                    if ($service_model->available == 0 || $service_model->active == 0) {
                        return responseJson(0, __('message.Service_id') . $service_model->id . __('message.not_available_or_not_active'));
                    }
                    $service_available_times = [];
                    if ($service_model->work_time)
                        $service_available_times = $this->service->inspection_service_available_reservation($request->date, $center->id, $this->model, $this->service, $service);
                    if (in_array(date("h:i a", strtotime($request->time)), $service_available_times) || !$service_model->work_time) {
                        $request_inspection->inspectionCenterService()->attach($service);
                    } else {
                        DB::rollBack();
                        return responseJson(0, 'error', __('message.this_time_is_not_available_for_services') . ' ' . __('message.Service_id') . $service);
                    }
                }

                DB::commit();
                return responseJson(1, 'success', new RequestInspectionCenterResource($request_inspection));

            } else {
                return responseJson(0, $request->id . __('message.not_available_for_reservation'));
            }


        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUserRequests()
    {
        try {
            $user = getAuthAPIUser();
            $user_requests = $user->inspectionRequests;
            return $user_requests;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function ShowUserRequest($request)
    {
        try {
            $user = getAuthAPIUser();
            $user_request = $user->inspectionRequests()->find($request->id);
            return $user_request;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
