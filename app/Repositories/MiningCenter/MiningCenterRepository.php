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

            foreach ($services as $service) {
                foreach ($service->offers as $offer) {
                    $discount_type = $offer->discount_type;
                    $percentage_value = ((100 - $offer->discount_value) / 100);
                    if ($discount_type == 'percentage') {
                        $price_after_discount = $service->price * $percentage_value;
                        $service->card_discount_value = $offer->discount_value . '%';
                        $service->card_price_after_discount = $price_after_discount . ' BHD';
                        $service->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                    } else {
                        $price_after_discount = $service->price - $offer->discount_value;
                        $service->card_discount_value = $offer->discount_value . ' BHD';
                        $service->card_price_after_discount = $price_after_discount . ' BHD';
                        $service->card_number_of_uses_times = $offer->number_of_uses_times == 'endless' ? __('words.endless') : $offer->specific_number;
                    }
                    $service->notes = $offer->notes;
                    $service->makeHidden('offers');
                }
            }
            return $services;
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
