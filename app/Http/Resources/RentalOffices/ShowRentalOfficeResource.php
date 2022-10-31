<?php

namespace App\Http\Resources\RentalOffices;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use App\Http\Resources\Reviews\ShowReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowRentalOfficeResource extends JsonResource
{
    public function toArray($request)
    {
        $cars =[];
        if ($request->has('vehicle_type')){
            $cars = $this->rental_office_cars()->where('vehicle_type',$request->vehicle_type)->get();
        }
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
            "reservation_availability" => $this->reservation_availability,
            "delivery_availability" => $this->delivery_availability,
            "reservation_active" => $this->reservation_active,
            "delivery_active" => $this->delivery_active,
            "work_time" => $this->work_time,
            "rental_laws" => $this->rental_laws,
            "payment_methods" => GetPaymentMethodsResource::collection($this->payment_methods),
            "contact" => $this->contact,
            "rental_office_cars" => ShowRentalOfficeCarResource::collection($cars),
            "rating" => $this->rating,
            "rating_count" => $this->rating_count,
            "is_reviewed" => $this->is_reviewed,
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "reviews" => ShowReviewResource::collection($this->reviews),
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "active" => $this->active,
            "available" => $this->available
        ];
    }
}
