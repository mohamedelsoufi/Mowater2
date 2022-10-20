<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CarWashAvailableTimeRequest;
use App\Http\Requests\API\RequestCarWashRequest;
use App\Http\Requests\API\ShowCarWashRequest;
use App\Http\Requests\API\ShowCarWashServiceRequest;
use App\Http\Requests\API\ShowUserCarWashRequest;
use App\Http\Resources\CarWash\CarWashMowaterOffersResource;
use App\Http\Resources\CarWash\CarWashOffersResource;
use App\Http\Resources\CarWash\CarWashServicesResource;
use App\Http\Resources\CarWash\GetCarWashesResource;
use App\Http\Resources\CarWash\RequestCarWashResource;
use App\Repositories\CarWash\CarWashInterface;
use Illuminate\Http\Request;

class CarWashController extends Controller
{
    private $car_wash;

    public function __construct(CarWashInterface $car_wash)
    {
        $this->car_wash = $car_wash;
    }

    public function index()
    {
        try {
            $data = $this->car_wash->getAll()->active()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', GetCarWashesResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show(ShowCarWashRequest $request)
    {
        try {
            $data = $this->car_wash->getCarWashById($request->id)->active()->first();
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($data);
            //update number of views end
            return responseJson(1, 'success', new GetCarWashesResource($data));
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getAllServices()
    {
        try {
            $data = $this->car_wash->getServices()->active()->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', CarWashServicesResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function ShowService(ShowCarWashServiceRequest $request)
    {
        try {
            $data = $this->car_wash->showService($request->id)->active()->first();
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            //update number of views start
            updateNumberOfViews($data);
            //update number of views end
            return responseJson(1, 'success', new CarWashServicesResource($data));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getMawaterOffers(ShowCarWashRequest $request)
    {
        try {
            $data = $this->car_wash->mawaterOffers($request->id)->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', CarWashMowaterOffersResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getOffers(ShowCarWashRequest $request)
    {
        try {
            $data = $this->car_wash->offers($request->id)->paginate(PAGINATION_COUNT);
            if (empty($data))
                return responseJson(0, __('message.no_result'));
            return responseJson(1, 'success', CarWashOffersResource::collection($data)->response()->getData(true));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getServiceAvailableTimes(CarWashAvailableTimeRequest $request)
    {
        try {
            $data = $this->car_wash->ServiceAvailableTimes($request);
            return responseJson(1, 'success', $data);
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function requestCarWash(RequestCarWashRequest $request)
    {
        try {
            return $this->car_wash->requestCarWash($request);
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function getUserRequests()
    {
        try {
            $data = $this->car_wash->getUserRequests()->paginate(PAGINATION_COUNT);
            return responseJson(1, 'success', RequestCarWashResource::collection($data)->response()->getData(true));
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function showUserRequest(ShowUserCarWashRequest $request)
    {
        try {
            $data = $this->car_wash->ShowUserRequest($request);
            return responseJson(1, 'success', new RequestCarWashResource($data));
        } catch
        (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
