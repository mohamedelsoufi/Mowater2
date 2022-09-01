<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ReserveInsuranceCompanyServiceRequest;
use App\Http\Requests\API\ShowInsuranceCompanyRequest;
use App\Http\Requests\API\ShowInsurancePackageRequest;
use App\Http\Requests\API\ShowInsuranceServiceReservationRequest;
use App\Http\Resources\Features\MawaterOffersResource;
use App\Http\Resources\Insurance\GetInsuranceCompaniesResource;
use App\Http\Resources\Insurance\InsuranceCompanyPackagesResource;
use App\Http\Resources\Insurance\ServiceReservationsResource;
use App\Http\Resources\Insurance\ShowInsuranceCompanyResource;
use App\Models\Branch;
use App\Models\DiscoutnCardUserUse;
use App\Models\FeatureInsuranceCompany;
use App\Models\InsuranceCompany;
use App\Models\InsuranceCompanyPackage;
use App\Models\InsuranceCompanyUse;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IsuranceCompanyController extends Controller
{
    public function index()
    {
        try {
            $companies = InsuranceCompany::active()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($companies))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetInsuranceCompaniesResource::collection($companies)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show_insurance_company(ShowInsuranceCompanyRequest $request)
    {
        try {
            $company = InsuranceCompany::with(['packages' => function ($q) {
                $q->active();
            }])->find($request->id);
            if (empty($company))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($company);
            //update number of views end

            return responseJson(1, 'success', new GetInsuranceCompaniesResource($company));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getDiscountCardOffers(ShowInsuranceCompanyRequest $request)
    {
        $company = InsuranceCompany::active()->find($request->id);

        $discount_cards = $company->discount_cards()->where('status', 'started')->get();

        if (!$discount_cards->isEmpty()) {

            $features = $company->packages()->whereHas('offers')->paginate(PAGINATION_COUNT);
            if (empty($features))
                return responseJson(0, __('message.no_result'));

            foreach ($features as $feature) {
                foreach ($feature->offers as $offer) {
                    $discount_type = $offer->discount_type;
                    $percentage_value = ((100 - $offer->discount_value) / 100);
                    if ($discount_type == 'percentage') {
                        $price_after_discount = $feature->price * $percentage_value;
                        $feature->card_discount_value = $offer->discount_value . '%';
                        $feature->card_price_after_discount = $price_after_discount . ' BHD';
                        $feature->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                    } else {
                        $price_after_discount = $feature->price - $offer->discount_value;
                        $feature->card_discount_value = $offer->discount_value . ' BHD';
                        $feature->card_price_after_discount = $price_after_discount . ' BHD';
                        $feature->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                    }
                    $feature->notes = $offer->notes;
                    $feature->makeHidden('offers');
                }
            }
//return $features;

            return responseJson(1, 'success', MawaterOffersResource::collection($features)->response()->getData(true));

        } else {
            return responseJson(0, 'error', __('message.something_wrong'));
        }

    }

    public function reserveInsuranceService(ReserveInsuranceCompanyServiceRequest $request)
    {
        try {
            $user = getAuthAPIUser();

            $branch_id = $request->branch_id;
            $branch = Branch::find($branch_id);
            if ($branch->branchable_type !== "App\\Models\\InsuranceCompany") {
                return responseJson(0, "error", __("message.not_exist"));
            }
            $insurance_id = $branch->branchable_id;
            $insurance_company = InsuranceCompany::find($insurance_id);

            if ($insurance_company->reservation_active == 0)
                return responseJson(0, 'error', __('message.reservation_not_active'));
            if ($insurance_company->reservation_availability == 0)
                return responseJson(0, 'error', __('message.reservation_not_available'));

            $package = InsuranceCompanyPackage::find($request->package_id);
            if ($package->active == 0)
                return responseJson(0, 'error', __('message.package_not_active'));


            $requested_data = $request->except(['is_mawater_card', 'barcode', 'smart_card_front', 'smart_card_back',
                'vehicle_ownership_front', 'vehicle_ownership_back', 'no_accident_certificate', 'owen_vehicles']);
            $requested_data['user_id'] = $user->id;

            $feature_offers = $insurance_company->packages()->whereHas('offers')->first();
            // use mawater card start
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
                        ->where('offerable_type', 'App\\Models\\InsuranceCompanyPackage')->first();

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

            $reservation = $branch->insuranceReservations()->create($requested_data);

            $reservation->upload_reserve_vehicle_images();
            return responseJson(1, "success", new ServiceReservationsResource($reservation));
        } catch (\Exception $e) {
            return responseJson(0, "error", $e->getMessage());
        }
    }

    public function getUserReservations()
    {
        try {
            $user = getAuthAPIUser();
            $reservations = $user->insuranceReservations()->latest()->get();
            if (empty($reservations))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', ServiceReservationsResource::collection($reservations)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowUserReservation(ShowInsuranceServiceReservationRequest $request)
    {
        try {
            $user = getAuthAPIUser();
            $reservation = $user->insuranceReservations()->find($request->id);
            if (empty($reservation))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', new ServiceReservationsResource($reservation));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowPackage(ShowInsurancePackageRequest $request)
    {
        try {
          $package = InsuranceCompanyPackage::find($request->id);
            if (empty($package))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', new InsuranceCompanyPackagesResource($package));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

}
