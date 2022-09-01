<?php

namespace App\Http\Resources\FuelStations;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowFuelStationResource extends JsonResource
{
    public function toArray($request)
    {
        foreach ($this->fuel_types as $type) {
            $fuel_type[] = __('words.' . $type);
        }
        foreach ($this->services as $service) {
            $fuel_service[] = [
                "id" => $service->id,
                "servable_type" => $service->servable_type,
                "servable_id" => $service->servable_id,
                "name" => $service->name,
                "description" => $service->description,
                "one_image" => $service->one_image,
                "price" => $service->price,
                "discount" => $service->discount,
                "discount_type" => $service->discount_type,
                "price_after_discount" => $service->price_after_discount,
                "number_of_views" => $service->number_of_views,
                "active_number_of_views" => $service->active_number_of_views,
                "active" => $service->active,
                "available" => $service->available,
            ];
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
            "services" => $fuel_service,
            "phones" => $this->phones,
            "contact" => $this->contact,
            "work_time" => $this->work_time,
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
