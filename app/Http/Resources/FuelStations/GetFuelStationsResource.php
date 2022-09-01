<?php

namespace App\Http\Resources\FuelStations;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetFuelStationsResource extends JsonResource
{
    public function toArray($request)
    {
        foreach ($this->fuel_types as $type){
            $fuel_type[] = __('words.'.$type);
        }
        return [
            "id" => $this->id,
            "logo" => $this->logo,
            "name" => $this->name,
            "address" => $this->address,
            "fuel_types" => $fuel_type,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "country_id" => $this->country_id,
            "country" => $this->country,
            "city_id" => $this->city_id,
            "city" => $this->city,
            "area_id" => $this->area_id,
            "area" => $this->area,
            "phones" => $this->phones,
            "payment_methods" => GetPaymentMethodsResource::collection($this->payment_methods),
            "work_time" => $this->work_time,
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
