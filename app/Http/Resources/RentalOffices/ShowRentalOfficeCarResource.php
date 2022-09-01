<?php

namespace App\Http\Resources\RentalOffices;

use App\Models\Branch;
use App\Models\RentalOffice;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ShowRentalOfficeCarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "rental_office_id" => $this->rental_office_id,
            "image" => $this->one_image,
            "vehicle_type" => $this->vehicle_type,
            "brand_id" => $this->brand_id,
            "brand" => $this->brand,
            "car_model_id" => $this->car_model_id,
            "car_model" => $this->car_model,
            "car_class_id" => $this->car_class_id,
            "car_class" => $this->car_class,
            "manufacture_year" => $this->manufacture_year,
            "color_id" => $this->color,
            "color" => $this->color,
            "properties" => RentalCarProperry::collection($this->properties),
            "daily_rental_price" => $this->daily_rental_price,
            "weekly_rental_price" => $this->weekly_rental_price,
            "monthly_rental_price" => $this->monthly_rental_price,
            "yearly_rental_price" => $this->yearly_rental_price,
            "branches" => branchInUse('RentalOffice', 'App\\Models\\RentalOfficeCar', $this->id),
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "active" => $this->active,
            "available" => $this->available,
        ];
    }
}
