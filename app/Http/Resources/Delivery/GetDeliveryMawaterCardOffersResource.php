<?php

namespace App\Http\Resources\Delivery;

use Illuminate\Http\Resources\Json\JsonResource;

class GetDeliveryMawaterCardOffersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"=>$this-> id,
            "delivery_man_id"=>$this-> delivery_man_id,
            "delivery_man"=>new GetDeliveriesResource($this->delivery_men),
            "category_id"=>$this-> category_id,
            "categories"=>$this-> categories->name,
            "card_discount_value"=>$this-> card_discount_value,
            "card_number_of_uses_times"=>$this-> card_number_of_uses_times,
            "notes"=>$this-> notes,
        ];
    }
}
