<?php

namespace App\Http\Resources\MiningCenter;

use Illuminate\Http\Resources\Json\JsonResource;

class GetMiningCenterOffersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "one_image" => $this->one_image,
            "name" => $this->name,
            "description" => $this->description,
            "mining_center_id" => $this->mining_center_id,
//            "tire_exchange" => new GetTireCenters($this->tireExchangeCenter),
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
