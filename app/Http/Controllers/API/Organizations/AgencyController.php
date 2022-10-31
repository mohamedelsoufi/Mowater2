<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowAgencyRequest;
use App\Http\Resources\Agencies\GetAgenciesResource;
use App\Http\Resources\Agencies\ShowAgencyResource;
use App\Http\Resources\Products\GetProductMowaterOffersResource;
use App\Http\Resources\Products\GetProductOffersResource;
use App\Http\Resources\Products\GetProductsResource;
use App\Http\Resources\Services\GetServiceMowaterOffersResource;
use App\Http\Resources\Services\GetServiceOffersResource;
use App\Http\Resources\Services\GetServicesResource;
use App\Http\Resources\Vehicles\GetVehicleMowaterOffersResource;
use App\Http\Resources\Vehicles\GetVehicleOffersResource;
use App\Models\Agency;
use App\Models\Branch;
use App\Models\Category;
use App\Models\DiscountCard;
use App\Models\Product;
use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use function PHPUnit\Framework\isEmpty;

class AgencyController extends Controller
{
    public function index()
    {
        try {
            $agencies = Agency::active()->available()
                ->search()->latest('id')->paginate(PAGINATION_COUNT);

            $agencies->makeHidden('car_models');
            if (empty($agencies))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetAgenciesResource::collection($agencies)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowAgencyRequest $request)
    {
        try {
            $agency = Agency::active()->find($request->id);
            if (empty($agency))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($agency);
            //update number of views end

            return responseJson(1, 'success', new ShowAgencyResource($agency));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function products(ShowAgencyRequest $request)
    {
        try {
            $agency = Agency::active()->find($request->id);
            if (!$agency) {
                return responseJson(0, 'Agency is not available now');
            }
            $products = $agency->products()->search()->active()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($products))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetProductsResource::collection($products)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function services(ShowAgencyRequest $request)
    {
        try {
            $agency = Agency::active()->find($request->id);
            if (!$agency) {
                return responseJson(0, 'Agency is not available now');
            }

            $services = $agency->services()->active()->latest('id')->paginate(PAGINATION_COUNT);
            if (empty($services))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetServicesResource::collection($services)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function categories()
    {
        try {
            //agency categories
            $categories = Category::whereHas('section', function (Builder $query) {

                $query->where('ref_name', 'Agency');

            })->latest('id')->get();
            if (empty($categories))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', $categories);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getDiscountCardOffers(ShowAgencyRequest $request)
    {
        try {
            $agency = Agency::selection()->active()->find($request->id);

            $discount_cards = $agency->discount_cards()->where('status', 'started')->get();

            if (!$discount_cards->isEmpty()) {
                $products = $agency->products()->wherehas('offers')->get();

                $services = $agency->services()->wherehas('offers')->get();

                $vehicles = $agency->vehicles()->with(['brand', 'car_model', 'car_class', 'files' => function ($query) {
                    $query->with('color');
                }])->overView()->wherehas('offers')->get();

                productMowaterCard($products);

                serviceMowaterCard($services);

                vehicleMowaterCard($vehicles);

                $merged = collect(GetVehicleMowaterOffersResource::collection($vehicles))
                    ->merge(GetProductMowaterOffersResource::collection($products))
                    ->merge(GetServiceMowaterOffersResource::collection($services))
                    ->paginate(PAGINATION_COUNT);
                return responseJson(1, 'success', $merged);

            } else {
                return responseJson(0, 'error', __('message.something_wrong'));
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getOffers(ShowAgencyRequest $request)
    {
        try {
            $agency = Agency::active()->find($request->id);

            // items not in mowater card and have offers start
            $products = $agency->products()->where('discount_type', '!=', '')->latest('id')->get();
            if (isset($products))
                $products->each(function ($item) {
                    $item->kind = 'product';
                    $item->is_mowater_card = false;
                });

            $services = $agency->services()->where('discount_type', '!=', '')->latest('id')->get();
            if (isset($services))
                $services->each(function ($item) {
                    $item->kind = 'service';
                    $item->is_mowater_card = false;
                });

            $vehicles = $agency->vehicles()->where('discount_type', '!=', '')->latest('id')->get();
            if (isset($vehicles))
                $vehicles->each(function ($item) {
                    $item->kind = 'vehicle';
                    $item->is_mowater_card = false;
                });
            // items not in mowater card and have offers end

            // items have mowater card start
            $mowater_products = $agency->products()->wherehas('offers')->latest('id')->get();

            $mowater_services = $agency->services()->wherehas('offers')->latest('id')->get();

            $mowater_vehicles = $agency->vehicles()->overView()->wherehas('offers')->latest('id')->get();

            if (isset($mowater_products)) {
                productOffers($mowater_products);
            }

            if (isset($mowater_services)) {
                serviceOffers($mowater_services);
            }

            if (isset($mowater_vehicles)) {
                vehicleOffers($mowater_vehicles);
            }
            // items have mowater card end
            //merge all results in one array
            $merged = collect(GetVehicleOffersResource::collection($vehicles))
                ->merge(GetVehicleOffersResource::collection($mowater_vehicles))
                ->merge(GetProductOffersResource::collection($products))
                ->merge(GetProductOffersResource::collection($mowater_products))
                ->merge(GetServiceOffersResource::collection($services))
                ->merge(GetServiceOffersResource::collection($mowater_services))
                ->paginate(PAGINATION_COUNT);

            return responseJson(1, 'success', $merged);
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
