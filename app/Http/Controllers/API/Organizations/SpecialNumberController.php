<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ReserveSpecialNumberRequest;
use App\Http\Requests\API\ShowSpecialNumberOrganizationRequest;
use App\Http\Requests\API\ShowSpecialNumberRequest;
use App\Http\Resources\SpecialNumbers\AllSpecialNumberCategoriesResource;
use App\Http\Resources\SpecialNumbers\AllSpecialNumbersResource;
use App\Http\Resources\SpecialNumbers\GetSpecialNumberOrganizationsResource;
use App\Http\Resources\SpecialNumbers\GetSpecialNumberReservationResource;
use App\Http\Resources\SpecialNumbers\ShowSpecialNumbersResource;
use App\Http\Resources\SpecialNumbers\SpecialNumberOrgOffersResource;
use App\Models\Branch;
use App\Models\Category;
use App\Models\DiscoutnCardUserUse;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Service;
use App\Models\SpecialNumber;
use App\Models\SpecialNumberOrganization;
use App\Models\SpecialNumberReservation;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialNumberController extends Controller
{
    public function index()
    {
        try {
            $special_numbers = SpecialNumber::active()->search()->sorting()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($special_numbers))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', AllSpecialNumbersResource::collection($special_numbers)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowSpecialNumberRequest $request)
    {
        try {
            $special_number = SpecialNumber::with('reviews')->search()->active()->find($request->id);

            if (empty($special_number)) {
                return responseJson(0, 'error', __('message.no_result'));
            }
            //update number of views start
            updateNumberOfViews($special_number);
            //update number of views end

            return responseJson(1, 'success', new ShowSpecialNumbersResource($special_number));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getOrganizations()
    {
        try {
            $organizations = SpecialNumberOrganization::active()->paginate(PAGINATION_COUNT);
            if (empty($organizations)) {
                return responseJson(0, 'error', __('message.no_result'));
            }
            return responseJson(1, 'success', GetSpecialNumberOrganizationsResource::collection($organizations)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function showOrganization(ShowSpecialNumberOrganizationRequest $request)
    {
        try {
            $organization = SpecialNumberOrganization::find($request->id);
            if (empty($organization)) {
                return responseJson(0, 'error', __('message.no_result'));
            }
            return responseJson(1, 'success', new GetSpecialNumberOrganizationsResource($organization));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getCategories()
    {
        try {
            $categories = Category::with('sub_categories')->where('section_id', 4)->search()->paginate(PAGINATION_COUNT);
            if (empty($categories))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', AllSpecialNumberCategoriesResource::collection($categories)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function special_number_reservation(ReserveSpecialNumberRequest $request)
    {

        // auth user
        $user = getAuthAPIUser();
        $special_number = SpecialNumber::find($request->special_number_id);

        if ($special_number->active == false)
            return responseJson(0, __('message.special_number_not_active'));

        if ($special_number->availability == false)
            return responseJson(0, __('message.special_number_not_available'));

        $special_number_reservations = SpecialNumberReservation::where('special_number_id', $request->special_number_id)->first();
        if ($special_number_reservations)
            return responseJson(0, __('message.special_number_reserved_before'));

        $validator = $request->except(['personal_ID_for_special', 'driving_license_for_special']);
        $validator['user_id'] = $user->id;

        // use mawater card start
        if ($request->is_mawater_card == true) {
            try {
                \DB::beginTransaction();
                $organization_id = $special_number->special_number_organization_id;
                $organization = SpecialNumberOrganization::find($organization_id);
                $special_number_offers = $organization->special_numbers()->wherehas('offers')->pluck('id')->toArray();
                if (in_array($request->special_number_id, $special_number_offers)) {
                    $special_number_offer = Offer::where('offerable_id', $request->special_number_id)
                        ->where('offerable_type', 'App\\Models\\SpecialNumber')->first();

                    $consumption = DiscoutnCardUserUse::where('barcode', $request->barcode)
                        ->where('offer_id', $special_number_offer->id)->first();
                    if (!$consumption) {
                        DiscoutnCardUserUse::create([
                            'user_id' => $user->id,
                            'barcode' => $request->barcode,
                            'offer_id' => $special_number_offer->id,
                            'original_number_of_uses' => $special_number_offer->specific_number,
                            'consumption_number' => 1
                        ]);
                    } else {
                        if ($consumption->consumption_number == $consumption->original_number_of_uses) {
                            return responseJson(0, 'error', 'you have reach max number of consumption for special number id: ' . $request->special_number_id);
                        }
                        $consumption->update([
                            'consumption_number' => $consumption->consumption_number + 1
                        ]);
                    }
                } else {
                    return responseJson(0, 'error', __('message.vehicle_id') . $request->special_number_id . __('message.service_not_fount_in_offer'));
                }


                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                return responseJson(0, 'error', $e->getMessage());
            }

        }
        // use mawater card end

        $reservation = SpecialNumberReservation::create($validator);
        $reservation->upload_reserve_vehicle_images();
        return responseJson(1, 'success', new GetSpecialNumberReservationResource($reservation));

    }

    public function getReservations()
    {
        try {
            // auth user
            $user = getAuthAPIUser();

            $reservations = $user->special_number_reservation()->latest('id')->paginate(PAGINATION_COUNT);

            if (!$reservations->isEmpty()) {
                return responseJson(1, 'success', GetSpecialNumberReservationResource::collection($reservations)->response()->getData(true));
            }
            return responseJson(0, __('message.no_result'));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getOffers(ShowSpecialNumberRequest $request)
    {
        $special_number_org = SpecialNumberOrganization::find($request->id);
        $special_numbers = $special_number_org->special_numbers()->whereHas('offers')->paginate(PAGINATION_COUNT);
        if (empty($special_numbers))
            return responseJson(0, __('message.no_result'));
        foreach ($special_numbers as $special_number) {
            foreach ($special_number->offers as $offer) {
                $discount_type = $offer->discount_type;
                $percentage_value = $offer->discount_value / 100;
                if ($discount_type == 'percentage') {
                    $price_after_discount = $special_number->price - $percentage_value;
                    $special_number->mawater_discount_type = $offer->discount_value . '%';
                    $special_number->price_after_mawater_discount = $price_after_discount . ' BHD';
                } else {
//                    $price_after_discount = $special_number->price - $offer->discount_value;
//                    $special_number->mawater_discount_type = $offer->discount_value . ' BHD';
//                    $special_number->price_after_mawater_discount = $price_after_discount . ' BHD';
                    $price_after_discount = $special_number->price - $offer->discount_value;
                    $special_number->card_discount_value = $offer->discount_value . ' BHD';
                    $special_number->card_price_after_discount = $price_after_discount . ' BHD';
                    $special_number->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                }
                $special_number->notes = $offer->notes;
                $special_number->makeHidden('offers');
            }
        }

        return responseJson(1, 'success', SpecialNumberOrgOffersResource::collection($special_numbers)->response()->getData(true));

    }
}
