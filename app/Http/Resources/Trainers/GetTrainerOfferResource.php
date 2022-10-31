<?php

namespace App\Http\Resources\Trainers;

use Illuminate\Http\Resources\Json\JsonResource;

class GetTrainerOfferResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["profile"] = $this->profile;
        $data["training_license"] = $this->training_license;
        $data["name"] = $this->name;
        $data["description"] = $this->description;
        $data["gender"] = $this->gender;
        $data["age"] = $this->age;
        $data["birth_date"] = $this->birth_date;
        $data["hour_price"] = $this->hour_price;
        $data["is_mowater_card"] = $this->is_mowater_card;
        if ($this->is_mowater_card === true) {
            $data["card_discount_value"] = $this->card_discount_value;
            $data["card_price_after_discount"] = $this->card_price_after_discount;
            $data["card_number_of_uses_times"] = $this->card_number_of_uses_times;
            $data["notes"] = $this->notes;
        }
        $data["discount_type"] = $this->discount_type;
        $data["discount"] = $this->discount;
        $data["price_after_discount"] = $this->price_after_discount;

        $data["vehicle_type"] = $this->vehicle_type;
        $data["vehicle_image"] = $this->vehicle_image;
        $data["conveyor_type"] = $this->conveyor_type;
        $data["manufacturing_year"] = $this->manufacturing_year;
        $data["brand_id"] = $this->brand_id;
        $data["brand"] = $this->brand;
        $data["car_model_id"] = $this->car_model_id;
        $data["car_model"] = $this->car_model;
        $data["car_class_id"] = $this->car_class_id;
        $data["car_class"] = $this->car_class;
        $data["country_id"] = $this->country_id;
        $data["country"] = $this->country;
        $data["city_id"] = $this->city_id;
        $data["city"] = $this->city;
        $data["area_id"] = $this->area_id;
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["active"] = $this->active;
        $data["available"] = $this->available;

        return $data;
    }
}
