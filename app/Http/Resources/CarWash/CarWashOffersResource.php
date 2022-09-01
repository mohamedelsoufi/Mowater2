<?php

namespace App\Http\Resources\CarWash;

use Illuminate\Http\Resources\Json\JsonResource;

class CarWashOffersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "one_image" => $this->one_image,
            "name" => $this->name,
            "description" => $this->description,
            "car_wash_id" => $this->car_wash_id,
//            "technical_inspection_center" => new GetCentersResource($this->inspectionCenter),
            "price" => $this->price,
            "discount" => $this->discount,
            "discount_type" => $this->discount_type,
            "price_after_discount" => $this->price_after_discount,
            "card_discount_value" => $this->card_discount_value,
            "card_price_after_discount" => $this->card_price_after_discount,
            "card_number_of_uses_times" => $this->card_number_of_uses_times,
            "notes" => $this->notes,
            "available" => $this->available,
            "active" => $this->active,
        ];
    }
}
