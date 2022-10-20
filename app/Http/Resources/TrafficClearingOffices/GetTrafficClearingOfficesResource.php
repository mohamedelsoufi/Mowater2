<?php

namespace App\Http\Resources\TrafficClearingOffices;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetTrafficClearingOfficesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "logo"=>$this->logo,
            "name" => $this->name,
            "description" => $this->description,
            "tax_number" => $this->tax_number,
            "country_id" => $this->country_id,
            "city_id" => $this->city_id,
            "area_id" => $this->area_id,
            "services" => TrafficServicesResource::collection($this->trafficServices),
            "payment_methods" => GetPaymentMethodsResource::collection($this->payment_methods),
            "rating" => $this->rating,
            "rating_count" => $this->rating_count,
            "is_reviewed" => $this->is_reviewed,
            "reviews" => $this->reviews,
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "available" => $this->available,
            "active" => $this->active,
        ];
    }
}
