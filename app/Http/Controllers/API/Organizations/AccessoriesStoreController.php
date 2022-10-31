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
use App\Http\Resources\AccessoriesStore\GetStoreOffersResource;
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
        $data = $this->store->getAll()->active()->paginate(PAGINATION_COUNT);
        if (empty($data))
            return responseJson(0, __('message.no_result'));
        return responseJson(1, 'success', GetAccessoriesStoresResource::collection($data)->response()->getData(true));
    }

    public function show(ShowAccessoriesStoreRequest $request)
    {
        $data = $this->store->getStoreById($request->id)->active()->first();
        if (empty($data))
            return responseJson(0, __('message.no_result'));
        //update number of views start
        updateNumberOfViews($data);
        //update number of views end
        return responseJson(1, 'success', new GetAccessoriesStoresResource($data));

    }

    public function getAllAccessories()
    {
        $data = $this->store->getAccessories()->active()->paginate(PAGINATION_COUNT);
        if (empty($data))
            return responseJson(0, __('message.no_result'));
        return responseJson(1, 'success', GetAccessoriesResource::collection($data)->response()->getData(true));
    }

    public function ShowAccessory(ShowAccessoryRequest $request)
    {
        $data = $this->store->showAccessory($request->id)->active()->first();
        if (empty($data))
            return responseJson(0, __('message.no_result'));
        //update number of views start
        updateNumberOfViews($data);
        //update number of views end
        return responseJson(1, 'success', new GetAccessoriesResource($data));
    }

    public function getMawaterOffers(ShowAccessoriesStoreRequest $request)
    {
        $data = $this->store->mawaterOffers($request->id)->paginate(PAGINATION_COUNT);
        if (empty($data))
            return responseJson(0, __('message.no_result'));
        return responseJson(1, 'success', GetStoreMawaterOffersResource::collection($data)->response()->getData(true));
    }

    public function getOffers(ShowAccessoriesStoreRequest $request)
    {
        $data = $this->store->offers($request->id)->paginate(PAGINATION_COUNT);
        if (empty($data))
            return responseJson(0, __('message.no_result'));
        return responseJson(1, 'success', GetStoreOffersResource::collection($data)->response()->getData(true));
    }

    public function purchase(PurchaseAccessoriesRequest $request)
    {
        return $data = $this->store->purchase($request);
    }

    public function getUserPurchases()
    {
        $data = $this->store->getUserPurchases()->paginate(PAGINATION_COUNT);
        if (empty($data))
            return responseJson(0, __('message.no_result'));
        return responseJson(1, 'success', GetPurchasesResource::collection($data)->response()->getData(true));
    }

    public function showUserPurchase(ShowUserAccessoriesPurchaseRequest $request)
    {
        $data = $this->store->ShowUserPurchase($request);
        if (empty($data))
            return responseJson(0, __('message.no_result'));
        return responseJson(1, 'success', new GetPurchasesResource($data));
    }
}
