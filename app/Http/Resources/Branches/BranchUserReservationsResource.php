<?php

namespace App\Http\Resources\Branches;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchUserReservationsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "reservable_type" => $this->reservable_type,
            "reservable_id" => $this->reservable_id,
            "user_id" => $this->user_id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "nickname" => $this->nickname,
            "nationality" => $this->nationality,
            "country_code" => $this->country_code,
            "phone" => $this->phone,
            "address" => $this->address,
            "branch_id" => $this->branch_id,
            "brand_id" => $this->brand_id,
            "car_model_id" => $this->car_model_id,
            "car_class_id" => $this->car_class_id,
            "manufacturing_year" => $this->manufacturing_year,
            "chassis_number" => $this->chassis_number,
            "number_plate" => $this->number_plate,
            "services" => $this->services,
            "products" => $this->products,
            "is_mawater_card" => $this->is_mawater_card,
            "price" => $this->price,
            "from" => $this->from,
            "to" => $this->to,
            "date" => $this->date,
            "time" => $this->time,
            "delivery" => $this->delivery,
            "status" => $this->status,
        ];
    }
}
