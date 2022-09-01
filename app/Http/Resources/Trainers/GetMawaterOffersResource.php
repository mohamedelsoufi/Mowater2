<?php

namespace App\Http\Resources\Trainers;

use Illuminate\Http\Resources\Json\JsonResource;

class GetMawaterOffersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "driving_trainer_id" => $this->driving_trainer_id,
            "trainer" => new GetTrainersResource($this->trainer),
            "training_type_id" => $this->training_type_id,
            "training_type" => $this->training_type->category,
            "card_discount_value" => $this->card_discount_value,
//            "card_price_after_discount"=>$this-> card_price_after_discount,
            "card_number_of_uses_times" => $this->card_number_of_uses_times,
            "notes" => $this->notes,
        ];
    }
}
