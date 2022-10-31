<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ReserveBrokerRequest;
use App\Http\Requests\API\ShowBrokerPackageRequest;
use App\Http\Requests\API\ShowBrokerRequest;
use App\Http\Requests\API\ShowBrokerReservationRequest;
use App\Http\Resources\Brokers\BrokerPackagesResource;
use App\Http\Resources\Brokers\GetBrokersResource;
use App\Http\Resources\Brokers\GetMowaterOffersResource;
use App\Http\Resources\Brokers\GetOffersResource;
use App\Http\Resources\Brokers\ReservationsResource;
use App\Models\Branch;
use App\Models\Broker;
use App\Models\BrokerPackage;
use App\Models\DiscoutnCardUserUse;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;

class BrokerController extends Controller
{
    public function index()
    {
        try {
            $brokers = Broker::active()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($brokers))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetBrokersResource::collection($brokers)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowBrokerRequest $request)
    {
        try {
            $broker = Broker::find($request->id);
            if (empty($broker))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($broker);
            //update number of views end

            return responseJson(1, 'success', new GetBrokersResource($broker));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getDiscountCardOffers(ShowBrokerRequest $request)
    {
        try {
            $broker = Broker::active()->find($request->id);

            $discount_cards = $broker->discount_cards()->where('status', 'started')->get();

            if (!$discount_cards->isEmpty()) {

                $features = $broker->brokerPackages()->whereHas('offers')->paginate(PAGINATION_COUNT);
                if (empty($features))
                    return responseJson(0, __('message.no_result'));
                GeneralMowaterCard($features);
                return responseJson(1, 'success', GetMowaterOffersResource::collection($features)->response()->getData(true));

            } else {
                return responseJson(0, 'error', __('message.something_wrong'));
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getOffers(ShowBrokerRequest $request)
    {
        try {
            $broker = Broker::active()->find($request->id);

            $packages = $broker->brokerPackages()->where('discount_type', '!=', '')->latest('id')->get();
            if (isset($packages))
                $packages->each(function ($item) {
                    $item->is_mowater_card = false;
                });

            $mowater_packages = $broker->brokerPackages()->whereHas('offers')->latest('id')->get();
            if (isset($mowater_packages)) {
                GeneralOffers($mowater_packages);
            }

            $merged = collect($packages)->merge($mowater_packages)->paginate(PAGINATION_COUNT);

            return responseJson(1, 'success', GetOffersResource::collection($merged)->response()->getData(true));

        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function reserveBrokerService(ReserveBrokerRequest $request)
    {
        try {
            $user = getAuthAPIUser();

            $branch_id = $request->branch_id;
            $branch = Branch::find($branch_id);
            if ($branch->branchable_type !== "App\\Models\\Broker") {
                return responseJson(0, "error", __("message.not_exist"));
            }
            $broker_id = $branch->branchable_id;
            $broker = Broker::find($broker_id);

            if ($broker->reservation_active == 0)
                return responseJson(0, 'error', __('message.reservation_not_active'));
            if ($broker->reservation_availability == 0)
                return responseJson(0, 'error', __('message.reservation_not_available'));


            $package = BrokerPackage::find($request->package_id);
            if ($package->active == 0)
                return responseJson(0, 'error', __('message.package_not_active'));

            $requested_data = $request->except(['is_mawater_card', 'barcode', 'driving_license_for_broker', 'vehicle_ownership_for_broker', 'no_accident_certificate_for_broker']);
            $requested_data['user_id'] = $user->id;

            $feature_offers = $broker->brokerPackages()->whereHas('offers')->first();

//            // use mawater card start
            if ($request->is_mawater_card == true) {
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

                    $offer = Offer::where('offerable_id', $feature_offers->id)
                        ->where('offerable_type', 'App\\Models\\BrokerPackage')->first();

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
//            // use mawater card end

            $reservation = $branch->brokerReservations()->create($requested_data);

            $reservation->upload_reserve_vehicle_images();
            return responseJson(1, "success", new ReservationsResource($reservation));
        } catch (\Exception $e) {
            return responseJson(0, "error", $e->getMessage());
        }
    }

    public function getUserReservations()
    {
        try {
            $user = getAuthAPIUser();
            $reservations = $user->brokerReservations()->latest()->get();
            if (empty($reservations))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', ReservationsResource::collection($reservations)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowUserReservation(ShowBrokerReservationRequest $request)
    {
        try {
            $user = getAuthAPIUser();
            $reservation = $user->brokerReservations()->find($request->id);
            if (empty($reservation))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', new ReservationsResource($reservation));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowPackage(ShowBrokerPackageRequest $request)
    {
        try {
            $package = BrokerPackage::find($request->id);
            if (empty($package))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', new BrokerPackagesResource($package));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
