<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\BranchAvailableTimeForTestRequest;
use App\Http\Requests\API\BranchesRequest;
use App\Http\Requests\API\BranchReservationRequest;
use App\Http\Requests\API\GetLookingUpBranchesRequest;
use App\Http\Requests\API\ShowBranchRequest;
use App\Http\Requests\API\ShowReservationRequest;
use App\Http\Requests\API\ShowServiceRequest;
use App\Http\Resources\Branches\BranchUserReservationsResource;
use App\Http\Resources\Branches\GetBranchesResource;
use App\Http\Resources\Branches\ShowBranchResource;
use App\Http\Resources\Products\GetBranchProductsResource;
use App\Http\Resources\Services\GetBranchServicesResource;
use App\Models\Branch;
use App\Models\DiscoutnCardUserUse;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use App\Models\Vehicle;

class BranchController extends Controller
{
    public function index(BranchesRequest $request)
    {
        try {
            $class = 'App\\Models\\' . $request->model_type; // 'App\\Models\branch'
            $model = new $class;                             // $model = branch
            $orgnization = $model->find($request->model_id); // $orgnization = branch->find(1);

            if (!$orgnization) {
                return responseJson(0, 'error');
            }

            $branches = $orgnization->branches()->search()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($branches))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetBranchesResource::collection($branches)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error');
        }
    }

    public function show(ShowBranchRequest $request)
    {
        try {
            $branch = Branch::find($request->id);
            if (empty($branch))
                return responseJson(0,__('message.no_result'));
            //update number of views start
            updateNumberOfViews($branch);
            //update number of views end

            return responseJson(1, 'success', new ShowBranchResource($branch));
        } catch (\Exception $e) {
            return responseJson(0, 'error');
        }
    }

    public function available_times(BranchAvailableTimeForTestRequest $request)
    {
        try {
            $available_times = branchAvailableTimeForTestDrive($request->date, $request->id, $request->vehicle_id);

            return responseJson(1, 'success', $available_times);
        } catch (\Exception $e) {
            return responseJson(0, 'error');
        }
    }

    public function products(ShowBranchRequest $request)
    {
        try {
            $branch = Branch::find($request->id);

            $products = $branch->available_products()->active()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($products))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetBranchProductsResource::collection($products)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function services(ShowBranchRequest $request)
    {
        try {
            $branch = Branch::find($request->id);

            $services = $branch->available_services()->active()->latest('id')->paginate();
            if (empty($services))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetBranchServicesResource::collection($services)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function vehicles(ShowBranchRequest $request)
    {
        try {
            $vehicles = Vehicle::with('brand', 'car_model', 'car_class')->overView()->search()->whereHas('branches', function ($query) use ($request) {
                $query->where('branches.id', $request->id);
            })->active()->latest('id')->paginate();
            if (empty($vehicles))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', $vehicles);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function reservations(BranchReservationRequest $request)
    {
        try {
            $id = $request->reservable_id;
            $date = $request->date;
            $time = $request->time;
            $totalServicePrice = 0;
            $totalProductPrice = 0;

            $auth_user = getAuthAPIUser();

            if ($request->has('services') || $request->has('products')) {
                $branch = Branch::with(['day_offs'])->find($id);
                if ($branch) {
                    if ($branch->reservation_active == 0)
                        return responseJson(0, 'error', __('message.reservation_not_active'));

                    if ($branch->reservation_availability == true) {

                        $user = $auth_user->id;

                        $requested_data = $request->except('services', 'products');
                        $requested_data['user_id'] = $user;
                        $requested_data['reservable_type'] = 'App\\Models\\Branch';
                        $product_offers = $branch->available_products()->wherehas('offers')->get()->pluck('id')->toArray();
                        $service_offers = $branch->available_services()->wherehas('offers')->get()->pluck('id')->toArray();

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

                                            // add price after mowater card from original price start
                                            $product_in_offer_class = new $product_offer->offerable_type;
                                            $product_in_offer = $product_in_offer_class->find($product_offer->offerable_id);

                                            $Original_price = $product_in_offer->price;

                                            $discount_type = $product_offer->discount_type;
                                            $percentage_value = ((100 - $product_offer->discount_value) / 100);
                                            if ($discount_type == 'percentage') {
                                                $price_after_mowater_discount = $Original_price * $percentage_value;
                                            } else {
                                                $price_after_mowater_discount = $Original_price - $Original_price->discount_value;
                                            }
                                            $totalProductPrice += $price_after_mowater_discount * $product['quantity'];
                                            // add price after mowater card from original price end

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

                                            // add price after mowater card from original price start
                                            $service_in_offer_class = new $service_offer->offerable_type;
                                            $service_in_offer = $service_in_offer_class->find($service_offer->offerable_id);

                                            $Original_price = $service_in_offer->price;

                                            $discount_type = $service_offer->discount_type;
                                            $percentage_value = ((100 - $service_offer->discount_value) / 100);
                                            if ($discount_type == 'percentage') {
                                                $price_after_mowater_discount = $Original_price * $percentage_value;
                                            } else {
                                                $price_after_mowater_discount = $Original_price - $Original_price->discount_value;
                                            }
                                            $totalServicePrice += $price_after_mowater_discount;
                                            // add price after mowater card from original price end

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
                                $requested_data['price'] = $totalServicePrice + $totalProductPrice;
                                DB::commit();
                            } catch (\Exception $e) {
                                DB::rollBack();
                                return responseJson(0, 'error', $e->getMessage());
                            }

                        }
                        // use mawater card end

                        DB::beginTransaction();
                        // total price without mowater card start
                        if ($request->is_mawater_card == 0) {
                            if ($request->has('services')) {
                                foreach ($request->services as $service) {
                                    $find_service = Service::find($service);
                                    if ($find_service->price_after_discount != 0)
                                        $totalServicePrice += $find_service->price_after_discount;
                                    $totalServicePrice += $find_service->price;
                                }
                            }
                            if ($request->has('products')) {
                                foreach ($request->products as $product) {
                                    $find_product = Product::find($product['id']);
                                    if ($find_product->price_after_discount != 0)
                                        $totalProductPrice += $find_product->price_after_discount * $product['quantity'];
                                    $totalProductPrice += $find_product->price * $product['quantity'];
                                }
                            }
                            $requested_data['price'] = $totalServicePrice + $totalProductPrice;
                        }

                        // total price without mowater card end

                        $reservation = $branch->reservations()->create($requested_data);

                        if ($request->has('services')) {
                            foreach ($request->services as $service) {
                                $service_model = Service::find($service);
                                if ($service_model->available == 0 || $service_model->active == 0) {
                                    return responseJson(0, __('message.Service_id') . $service_model->id . __('message.not_available_or_not_active'));
                                }
                                $service_available_times = [];
                                if ($service_model->work_time)
                                    $service_available_times = service_available_reservation($id, $date, $service, $branch);
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
                                $product_model = Product::find($product['id']);
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
            $reservations = userReservations("Branch");
            if (empty($reservations))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', BranchUserReservationsResource::collection($reservations)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowUserReservation(ShowReservationRequest $request)
    {
        try {
            getAuthAPIUser();
            $reservation = userReservation("Branch");
            if (empty($reservation))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', new BranchUserReservationsResource($reservation));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getLookingUpBranches(GetLookingUpBranchesRequest $request)
    {
        try {
            $class = 'App\\Models\\' . $request->model_type;
            $model = new $class;
            $organization = $model->find($request->model_id);
            $branch_Ids = $organization->branches()->pluck('id');

            if ($request->has('vehicle_id')) {
                $branch_use = \DB::table('branch_use')->where('usable_type', 'App\\Models\\Vehicle')
                    ->where('usable_id', $request->vehicle_id)
                    ->whereIn('branch_id', $branch_Ids)->pluck('branch_id');

                $vehicles_in_branches = Branch::whereIn('id', $branch_use)->paginate(PAGINATION_COUNT);
                return responseJson(1, 'success', $vehicles_in_branches);
            }

            if ($request->has('product_id')) {
                $branch_use = DB::table('branch_use')->where('usable_type', 'App\\Models\\Product')
                    ->where('usable_id', $request->product_id)
                    ->whereIn('branch_id', $branch_Ids)->pluck('branch_id');

                $products_in_branches = Branch::whereIn('id', $branch_use)->paginate(PAGINATION_COUNT);
                return responseJson(1, 'success', $products_in_branches);
            }

            if ($request->has('service_id')) {
                $branch_use = \DB::table('branch_use')->where('usable_type', 'App\\Models\\Service')
                    ->where('usable_id', $request->service_id)
                    ->whereIn('branch_id', $branch_Ids)->pluck('branch_id');

                $services_in_branches = Branch::whereIn('id', $branch_use)->paginate(PAGINATION_COUNT);
                return responseJson(1, 'success', $services_in_branches);
            }

            return responseJson(0, 'error', __('message.no_result'));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function serviceAvailableTime(ShowServiceRequest $request)
    {
        try {
            $model_type = 'App\\Models\\' . $request->model_type;
            $model_id = $request->model_id;
            $module = new $model_type;
            $date = $request->date;
            $service_id = $request->id;

            $available_times = service_available_reservation($model_id, $date, $service_id, $module);

            return responseJson(1, "success", $available_times);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

}
