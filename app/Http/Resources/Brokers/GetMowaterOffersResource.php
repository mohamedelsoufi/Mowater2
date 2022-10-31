<?php

namespace App\Http\Resources\Brokers;

use Illuminate\Http\Resources\Json\JsonResource;

class GetMowaterOffersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "broker_id" => $this->broker_id,
            "broker" => $this->broker->name,
            "coverage_type_id" => $this->coverage_type_id,
            "coverage_type" => $this->coverageType->name,
            "price" => $this->price,
            "card_discount_value" => $this->card_discount_value,
            "card_price_after_discount" => $this->card_price_after_discount,
            "card_number_of_uses_times" => $this->card_number_of_uses_times,
            "notes" => $this->notes,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "available" => $this->available,
            "active" => $this->active,
        ];
    }
}
