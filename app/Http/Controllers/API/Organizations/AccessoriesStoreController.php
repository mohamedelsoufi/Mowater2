<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PurchaseAccessoriesRequest;
use App\Http\Requests\API\ShowAccessoriesStoreRequest;
use App\Http\Requests\API\ShowAccessoryRequest;
use App\Http\Requests\API\ShowUserAccessoriesPurchaseRequest;
use App\Http\Resources\AccessoriesStore\GetAccessoriesResource;
use App\Http\Resources\AccessoriesStore\GetAccessoriesStoresResource;
use App\Http\Resources\AccessoriesStore\GetPurchasesResource;
use App\Http\Resources\AccessoriesStore\GetStoreMawaterOffersResource;
use App\Repositories\AccessoriesStore\AccessoriesStoreRepository;
use Illuminate\Http\Request;

class AccessoriesStoreController extends Controller
{
    private $store;

    public function __construct(AccessoriesStoreRepository $store)
    {
        $this->store = $store;
    }

    public function index()
    {
        try {
            $data = $this->store->getAll()->active()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetAccessoriesStoresResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowAccessoriesStoreRequest $request)
    {
        try {
            try {
                $data = $this->store->getStoreById($request->id)->active()->first();
                if (empty($data))
                    return responseJson(0, __('message.no_result'));
                //update number of views start
                updateNumberOfViews($data);
                //update number of views end
                return responseJson(1, 'success', new GetAccessoriesStoresResource($data));
            } catch
            (\Exception $e) {
                return responseJson(0, 'error', $e->getMessage());
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getAllAccessories()
    {
        try {
            $data = $this->store->getAccessories()->active()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetAccessoriesResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowAccessory(ShowAccessoryRequest $request)
    {
        try {
            $data = $this->store->showAccessory($request->id)->active()->first();
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($data);
            //update number of views end
            return responseJson(1, 'success', new GetAccessoriesResource($data));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getMawaterOffers(ShowAccessoriesStoreRequest $request)
    {
        try {
            try {
                $data = $this->store->mawaterOffers($request->id)->paginate(PAGINATION_COUNT);
                if (empty($data))
                    return responseJson(0, __('message.no_result'));
                return responseJson(1, 'success', GetStoreMawaterOffersResource::collection($data)->response()->getData(true));
            } catch (\Exception $e) {
                return responseJson(0, 'error', $e->getMessage());
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function purchase(PurchaseAccessoriesRequest $request)
    {
        try {
            return $data = $this->store->purchase($request);

        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUserPurchases()
    {
        try {
            $data = $this->store->getUserPurchases()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetPurchasesResource::collection($data)->response()->getData(true));
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function showUserPurchase(ShowUserAccessoriesPurchaseRequest $request)
    {
        try {
            $data = $this->store->ShowUserPurchase($request);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', new GetPurchasesResource($data));
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
