<?php

namespace App\Http\Resources\TrafficClearingOffices;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowTrafficClearingOfficeRequestResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];
        $service = $request->traffic_clearing_service_id;
        $data["id"] = $this->id;
        $data["first_name"] = $this->first_name;
        $data["last_name"] = $this->last_name;
        $data["nickname"] = $this->nickname;
        $data["country_code"] = $this->country_code;
        $data["phone"] = $this->phone;
        $data["nationality"] = $this->nationality;
        $data["service"] = $this->service;
        $data["user"] = $this->user;
        $data["id_type"] = $this->id_type;
        $data["personal_id"] = $this->personal_id;
        $data["smart_card_expiry_date"] = $this->smart_card_expiry_date;
        if ($service != 2 || $service != 5) {
            $data["date"] = $this->date;
            $data["chassis_number"] = $this->chassis_number;
        }
        $data["number_plate"] = $this->number_plate;
        if ($service == 5) {
            $data["brand_id"] = $this->brand->name;
            $data["car_model_id"] = $this->car_model->name;
            $data["car_class_id"] = $this->car_class->name;
            $data["manufacturing_year"] = $this->manufacturing_year;
            $data["smart_card_id"] = $this->files()->where('type', 'smart_card_id')->first()->path;
            $data["vehicle_ownership"] = $this->files()->where('type', 'vehicle_ownership')->first()->path;
            $data["disclaimer_image"] = $this->files()->where('type', 'disclaimer_image')->first()->path;
        }
        $data["is_mawater_card"] = $this->is_mawater_card;

        return $data;
    }
}
