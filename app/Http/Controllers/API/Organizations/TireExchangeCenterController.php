<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowTireExchangeCenterRequest;
use App\Http\Requests\API\ShowTireExchangeCenterServiceRequest;
use App\Http\Resources\TechnicalInspectionCenter\InspectionCenterOffersResource;
use App\Http\Resources\TechnicalInspectionCenter\InspectionCenterServicesResource;
use App\Http\Resources\TireExchangeCenter\GetTireCenters;
use App\Http\Resources\TireExchangeCenter\GetMiningCenterOffersResource;
use App\Http\Resources\TireExchangeCenter\GetTireExchangeMowaterOffersResource;
use App\Http\Resources\TireExchangeCenter\GetTireExchangeOffersResource;
use App\Http\Resources\TireExchangeCenter\GetTireExchangeServicesResource;
use App\Repositories\TireExchangeCenter\TireExchangeCenterInterface;

class TireExchangeCenterController extends Controller
{
    private $center;

    public function __construct(TireExchangeCenterInterface $tire)
    {
        $this->center = $tire;
    }

    public function index()
    {
        try {
            $data = $this->center->getAll()->active()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetTireCenters::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowTireExchangeCenterRequest $request)
    {
        try {
            $data = $this->center->getCenterById($request->id)->active()->first();
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            //update number of views start
            updateNumberOfViews($data);
            //update number of views end
            return responseJson(1, 'success', new GetTireCenters($data));
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getAllServices()
    {
        try {
            $data = $this->center->getServices()->active()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetTireExchangeServicesResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowService(ShowTireExchangeCenterServiceRequest $request)
    {
        try {
            $data = $this->center->showService($request->id)->active()->first();
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            //update number of views start
            updateNumberOfViews($data);
            //update number of views end
            return responseJson(1, 'success', new GetTireExchangeServicesResource($data));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getMawaterOffers(ShowTireExchangeCenterRequest $request)
    {
        try {
            $data = $this->center->mawaterOffers($request->id)->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetTireExchangeMowaterOffersResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getOffers(ShowTireExchangeCenterRequest $request)
    {
        try {
            $data = $this->center->offers($request->id)->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetTireExchangeOffersResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
