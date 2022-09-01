<?php

namespace App\Http\Resources\TireExchangeCenter;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use App\Http\Resources\TechnicalInspectionCenter\InspectionCenterServicesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetTireCenters extends JsonResource
{
    public function toArray($request)
    {
        $data = [];
        $data["id"] = $this->id;
        $data["logo"] = $this->logo;
        $data["name"] = $this->name;
        $data["description"] = $this->description;
        $data["tax_number"] = $this->tax_number;
        $data["city_id"] = $this->city_id;
        $data["address"] = $this->address;
        if ($request->routeIs('tire-centers.show')){
            $data["services"] = GetTireExchangeServicesResource::collection($this->tireExchangeService);
        }
        $data['payment_methods'] =  GetPaymentMethodsResource::collection($this->payment_methods);
        $data['contact'] = $this->contact;
        $data['work_time'] = $this->work_time;
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["rating"] = $this->rating;
        $data["rating_count"] = $this->rating_count;
        $data["is_reviewed"] = $this->is_reviewed;
        $data['is_favorite'] = $this->is_favorite;
        $data['is_favorite'] = $this->is_favorite;
        $data['favorites_count'] = $this->is_favorite;
        $data["available"] = $this->available;
        $data["active"] = $this->active;

        if ($request->routeIs('inspection-centers.show')){
            $data["reviews"] = $this->reviews;
        }
        return $data;
    }
}
