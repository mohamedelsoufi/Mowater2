<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowMiningCenterRequest;
use App\Http\Requests\API\ShowMiningCenterServiceRequest;
use App\Http\Resources\MiningCenter\GetMiningCenterOffersResource;
use App\Http\Resources\MiningCenter\GetMiningCenters;
use App\Http\Resources\MiningCenter\GetMiningCenterServicesResource;
use App\Http\Resources\TireExchangeCenter\GetTireCenters;
use App\Repositories\MiningCenter\MiningCenterInterface;
use Illuminate\Http\Request;

class MiningCenterController extends Controller
{
    private $center;

    public function __construct(MiningCenterInterface $miningCenter)
    {
        $this->center = $miningCenter;
    }

    public function index()
    {
        try {
            $data = $this->center->getAll()->active()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetMiningCenters::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowMiningCenterRequest $request)
    {
        try {
            $data = $this->center->getCenterById($request->id)->active()->first();
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            //update number of views start
            updateNumberOfViews($data);
            //update number of views end
            return responseJson(1, 'success', new GetMiningCenters($data));
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
            return responseJson(1, 'success', GetMiningCenterServicesResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowService(ShowMiningCenterServiceRequest $request)
    {
        try {
            $data = $this->center->showService($request->id)->active()->first();
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            //update number of views start
            updateNumberOfViews($data);
            //update number of views end
            return responseJson(1, 'success', new GetMiningCenterServicesResource($data));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getMawaterOffers(ShowMiningCenterRequest $request)
    {
        try {
            $data = $this->center->mawaterOffers($request->id)->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetMiningCenterOffersResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
