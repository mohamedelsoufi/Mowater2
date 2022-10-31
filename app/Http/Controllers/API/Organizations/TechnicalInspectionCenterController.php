<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\InspectionCenterAvailableTimeRequest;
use App\Http\Requests\API\RequestTechnicalInspectionRequest;
use App\Http\Requests\API\ShowInspectionCenterServiceRequest;
use App\Http\Requests\API\ShowTechnicalInspectionCenterRequest;
use App\Http\Requests\API\ShowUserInspectionRequest;
use App\Http\Resources\Insurance\InsuranceMowaterOffersResource;
use App\Http\Resources\TechnicalInspectionCenter\GetCarWashesResource;
use App\Http\Resources\TechnicalInspectionCenter\GetCentersResource;
use App\Http\Resources\TechnicalInspectionCenter\InspectionCenterMowaterOffersResource;
use App\Http\Resources\TechnicalInspectionCenter\InspectionCenterOffersResource;
use App\Http\Resources\TechnicalInspectionCenter\InspectionCenterServicesResource;
use App\Http\Resources\TechnicalInspectionCenter\RequestInspectionCenterResource;
use App\Repositories\TechnicalInspectionCenter\TechnicalInspectionCenterInterface;
use Illuminate\Http\Request;

class TechnicalInspectionCenterController extends Controller
{
    private $center;

    public function __construct(TechnicalInspectionCenterInterface $center)
    {
        $this->center = $center;
    }

    public function index()
    {
        try {
            $data = $this->center->getAll()->active()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', GetCentersResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowTechnicalInspectionCenterRequest $request)
    {
        try {
            $data = $this->center->getCenterById($request->id)->active()->first();
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            //update number of views start
            updateNumberOfViews($data);
            //update number of views end
            return responseJson(1, 'success', new GetCentersResource($data));
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
            return responseJson(1, 'success', InspectionCenterServicesResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowService(ShowInspectionCenterServiceRequest $request)
    {
        try {
            $data = $this->center->showService($request->id)->active()->first();
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            //update number of views start
            updateNumberOfViews($data);
            //update number of views end
            return responseJson(1, 'success', new InspectionCenterServicesResource($data));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getMawaterOffers(ShowTechnicalInspectionCenterRequest $request)
    {
        try {
            $data = $this->center->mawaterOffers($request->id)->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', InspectionCenterMowaterOffersResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getOffers(ShowTechnicalInspectionCenterRequest $request)
    {
        try {
            $data = $this->center->offers($request->id)->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
            return responseJson(1, 'success', InspectionCenterOffersResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getServiceAvailableTimes(InspectionCenterAvailableTimeRequest $request)
    {
        try {
            $data = $this->center->ServiceAvailableTimes($request);
            return responseJson(1,'success',$data);
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function requestTechnicalInspection(RequestTechnicalInspectionRequest $request)
    {
        try {
            return $this->center->requestTechnicalInspection($request);
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUserRequests(){
        try {
            $data = $this->center->getUserRequests()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
             return responseJson(1,'success',RequestInspectionCenterResource::collection($data)->response()->getData(true));
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function showUserRequest(ShowUserInspectionRequest $request){
        try {
            $data = $this->center->ShowUserRequest($request);
            if (empty($data))
                return responseJson(0,__('message.no_result'));
             return responseJson(1,'success',new RequestInspectionCenterResource($data));
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
