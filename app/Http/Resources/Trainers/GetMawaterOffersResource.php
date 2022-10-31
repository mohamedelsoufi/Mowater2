<?php

namespace App\Http\Resources\Trainers;

use Illuminate\Http\Resources\Json\JsonResource;

class GetMawaterOffersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "driving_trainer_id" => $this->offerable_id,
            "trainer" => $this->offerable->name,
            "hour_price" => $this->hour_price,
            "card_discount_value" => $this->card_discount_value,
            "card_price_after_discount"=>$this-> card_price_after_discount,
            "card_number_of_uses_times" => $this->card_number_of_uses_times,
            "notes" => $this->notes,
        ];
    }
}
