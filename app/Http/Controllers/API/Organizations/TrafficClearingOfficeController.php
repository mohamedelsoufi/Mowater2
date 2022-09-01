<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowTrafficServiceRequest;
use App\Http\Requests\API\StoreTrafficClearingOfficeRequest;
use App\Http\Requests\API\ShowTrafficClearingOfficeRequest;
use App\Http\Resources\TrafficClearingOffices\GetServicesResource;
use App\Http\Resources\TrafficClearingOffices\GetTrafficClearingOfficeMawaterOffersResource;
use App\Http\Resources\TrafficClearingOffices\GetTrafficClearingOfficesResource;
use App\Http\Resources\TrafficClearingOffices\ShowTrafficClearingOfficeRequestResource;
use App\Http\Resources\TrafficClearingOffices\ShowTrafficClearingOfficeResource;
use App\Models\Branch;
use App\Models\DiscoutnCardUserUse;
use App\Models\Offer;
use App\Models\Service;
use App\Models\SpecialNumberOrganization;
use App\Models\TrafficClearingOffice;
use App\Models\TrafficClearingOfficeRequest;
use App\Models\TrafficClearingService;
use App\Models\TrafficClearingServiceUse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrafficClearingOfficeController extends Controller
{
    public function index()
    {
        try {
            $traffic_clearing_offices = TrafficClearingOffice::active()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($traffic_clearing_offices))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetTrafficClearingOfficesResource::collection($traffic_clearing_offices)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function Show(ShowTrafficClearingOfficeRequest $request)
    {
        try {
            $traffic_clearing_office = TrafficClearingOffice::active()->find($request->id);
            if (empty($traffic_clearing_office))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($traffic_clearing_office);
            //update number of views end
            return responseJson(1, 'success', new ShowTrafficClearingOfficeResource($traffic_clearing_office));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function showService(ShowTrafficServiceRequest $request)
    {
        try {
            $traffic_service_use = TrafficClearingServiceUse::find($request->id);
            $traffic_service = TrafficClearingService::where('id',$traffic_service_use->traffic_clearing_service_id)->first();
            if (empty($traffic_service))
                return responseJson(0, __('message.no_result'));

            return responseJson(1, 'success', new GetServicesResource($traffic_service));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getServices()
    {
        try {
            $services = TrafficClearingService::all();
            if (empty($services))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetServicesResource::collection($services));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getDiscountCardOffers(ShowTrafficClearingOfficeRequest $request)
    {
        try {
            $traffic_clearing_office = TrafficClearingOffice::active()->find($request->id);

            $discount_cards = $traffic_clearing_office->discount_cards()->where('status', 'started')->get();

            if (!$discount_cards->isEmpty()) {
                $services = TrafficClearingServiceUse::where('traffic_clearing_office_id', $request->id)->whereHas('offers')->paginate(PAGINATION_COUNT);
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

                return responseJson(1, 'success', GetTrafficClearingOfficeMawaterOffersResource::collection($services)->response()->getData(true));

            } else {
                return responseJson(0, 'error', __('message.something_wrong'));
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }

    }

    public function storeTrafficClearingOfficeRequests(StoreTrafficClearingOfficeRequest $request)
    {
        try {
            // auth user
            $user = getAuthAPIUser();
            $requested_data = $request->except(['barcode', 'smart_card_id', 'vehicle_ownership', 'disclaimer_image']);
            if ($request->is_mawater_card == 1) {
                $check = $user->discount_cards()->where('barcode', $request->barcode)->first();
                if (!$check)
                    return responseJson(0, 'error', __('message.not_subscribed'));
            }
            $requested_data['user_id'] = $user->id;
            $traffic_request = TrafficClearingOfficeRequest::create($requested_data);
            $traffic_request->upload_request_traffic_images();
//            return $traffic_request;

            return responseJson(1, 'success', new ShowTrafficClearingOfficeRequestResource($traffic_request));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUserTrafficClearingOfficeRequests()
    {
        try {
            // auth user
            $user = getAuthAPIUser();
            $reqquests = $user->trafficClearingOfficeRequests()->paginate(PAGINATION_COUNT);
            if (empty($reqquests))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', ShowTrafficClearingOfficeRequestResource::collection($reqquests)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }


}
