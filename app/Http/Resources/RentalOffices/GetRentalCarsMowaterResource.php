<?php

namespace App\Http\Resources\RentalOffices;

use Illuminate\Http\Resources\Json\JsonResource;

class GetRentalCarsMowaterResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["rental_office_id"] = $this->rental_office_id;
        $data["rental_office"] = $this->rental_office->name;
        $data["one_image"] = $this->one_image ? $this->one_image : '';
        $data["vehicle_type"] = $this->vehicle_type;
        $data["brand_id"] = $this->brand_id;
        $data["brand"] = $this->brand->name;
        $data["car_model_id"] = $this->car_model_id;
        $data["car_model"] = $this->car_model->name;
        $data["car_class_id"] = $this->car_class_id;
        $data["car_class"] = $this->car_class->name;
        $data["manufacturing_year"] = $this->manufacturing_year;
        $data["color_id"] = $this->color_id;
        $data["color"] = $this->color->name;
        $data["daily_rental_price"] = $this->daily_rental_price;
        $data["weekly_rental_price"] = $this->weekly_rental_price;
        $data["monthly_rental_price"] = $this->monthly_rental_price;
        $data["yearly_rental_price"] = $this->yearly_rental_price;
        $data["card_discount_value"] = $this->card_discount_value;
        $data["card_daily_price_after_discount"] = $this->card_daily_price_after_discount;
        $data["card_weekly_price_after_discount"] = $this->card_weekly_price_after_discount;
        $data["card_monthly_price_after_discount"] = $this->card_monthly_price_after_discount;
        $data["card_yearly_price_after_discount"] = $this->card_yearly_price_after_discount;
        $data["card_number_of_uses_times"] = $this->card_number_of_uses_times;
        $data["notes"] = $this->notes;
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["available"] = $this->available;
        $data["active"] = $this->active;

        return $data;
    }
}
