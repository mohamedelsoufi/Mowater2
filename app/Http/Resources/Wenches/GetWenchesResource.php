<?php

namespace App\Http\Resources\Wenches;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use App\Http\Resources\Reviews\ShowReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetWenchesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "logo" => $this->logo,
            "name" => $this->name,
            "description" => $this->description,
            "wench_type" => $this->wench_type,
            "tax_number" => $this->tax_number,
            "year_founded" => $this->year_founded,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "location_type" => $this->location_type,
            "country_id" => $this->country_id,
            "country" => $this->country,
            "city_id" => $this->city_id,
            "city" => $this->city,
            "area_id" => $this->area_id,
            "area" => $this->area,
            "payment_methods" => GetPaymentMethodsResource::collection($this->payment_methods),
            "reservation_availability" => $this->reservation_availability,
            "delivery_availability" => $this->delivery_availability,
            "rating" => $this->rating,
            "rating_count" => $this->rating_count,
            "is_reviewed" => $this->is_reviewed,
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "reviews" => ShowReviewResource::collection($this->reviews),
            "status" => $this->status,
            "available" => $this->available,
            "active" => $this->active,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
        ];
    }
}
