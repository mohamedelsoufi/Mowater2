<?php

namespace App\Http\Resources\Garages;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use App\Http\Resources\Reviews\ShowReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetGaragesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "logo" => $this->logo,
            "name" => $this->name,
            "description" => $this->description,
            "tax_number" => $this->tax_number,
            "year_founded" => $this->year_founded,
            "country_id" => $this->country_id,
            "country" => $this->country,
            "city_id" => $this->city_id,
            "city" => $this->city,
            "area_id" => $this->area_id,
            "area" => $this->area,
            "categories" => GetCategoriesForGarageResource::collection($this->categories),
            "reservation_availability" => $this->reservation_availability,
            "delivery_availability" => $this->delivery_availability,
            "payment_methods" => GetPaymentMethodsResource::collection($this->payment_methods),
            "rating" => $this->rating,
            "rating_count" => $this->rating_count,
            "is_reviewed" => $this->is_reviewed,
            "reviews" => ShowReviewResource::collection($this->reviews),
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "active" => $this->active,
            "available" => $this->available,


        ];
    }
}
