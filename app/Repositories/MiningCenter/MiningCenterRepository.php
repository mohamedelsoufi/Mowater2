<?php


namespace App\Repositories\MiningCenter;


use App\Models\MiningCenter;
use App\Models\MiningCenterService;

class MiningCenterRepository implements MiningCenterInterface
{
    private $model;
    private $service;

    public function __construct(MiningCenter $model, MiningCenterService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }

    public function getAll()
    {
        try {
            $centers = $this->model->search()->latest('id');
            return $centers;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getCenterById($request)
    {
        try {
            $center = $this->model->where('id',$request);
            return $center;

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function mawaterOffers($request)
    {
        try {
            $center = $this->model->find($request);

            $discount_cards = $center->discount_cards()->where('status', 'started')->get();

            if ($discount_cards->isEmpty()) {
                return responseJson(0, 'error', __('message.something_wrong'));
            }
            $services = $center->miningCenterService()->whereHas('offers')->get();

            GeneralMowaterCard($services);
            return $services;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function offers($request)
    {
        try {
            $center = $this->model->find($request);

            $services = $center->miningCenterService()->where('discount_type', '!=', '')->latest('id')->get();
            if (isset($services))
                $services->each(function ($item) {
                    $item->is_mowater_card = false;
                });

            $mowater_services = $center->miningCenterService()->whereHas('offers')->get();
            if (isset($mowater_services)) {
                GeneralOffers($mowater_services);
            }
            return collect($services)->merge($mowater_services)->paginate(PAGINATION_COUNT);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getServices()
    {
        try {
            $services =  $this->service->latest('id');
            return $services;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function showService($request)
    {
        try {
            $service = $this->service->where('id', $request);
            return $service;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
