<?php

namespace App\Http\Resources\CarWash;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestCarWashResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];
        $data["id"] = $this->id;
        $data["car_wash_id"] = $this->car_wash_id;
        if ($request->routeIs('car-washes.show-request')) {
            $data["carWash"] = $this->carWash;
        }
        $data["user_id"] = $this->user_id;
        if ($request->routeIs('car-washes.show-request')) {
            $data["user"] = $this->user;
        }
        $data["services"] = CarWashServicesResource::collection($this->carWashServices);

        $data["first_name"] = $this->first_name;
        $data["last_name"] = $this->last_name;
        $data["nickname"] = $this->nickname;
        $data["country_code"] = $this->country_code;
        $data["phone"] = $this->phone;
        $data["nationality"] = $this->nationality;
        $data["brand_id"] = $this->brand_id;
        if ($request->routeIs('car-washes.show-request')) {
            $data["brand"] = $this->brand;
        }
        $data["car_model_id"] = $this->car_model_id;
        if ($request->routeIs('car-washes.show-request')) {
            $data["car_model"] = $this->car_model;
        }
        $data["car_class_id"] = $this->car_class_id;
        if ($request->routeIs('car-washes.show-request')) {
            $data["car_class"] = $this->car_class;
        }
        $data["manufacturing_year"] = $this->manufacturing_year;
        $data["chassis_number"] = $this->chassis_number;
        $data["number_plate"] = $this->number_plate;
        $data["date"] = $this->date;
        $data["time"] = $this->time;
        $data["is_mawater_card"] = $this->is_mawater_card;
        return $data;
    }
}
