<?php

namespace App\Http\Resources\TechnicalInspectionCenter;

use Illuminate\Http\Resources\Json\JsonResource;

class InspectionCenterOffersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "one_image" => $this->one_image,
            "name" => $this->name,
            "description" => $this->description,
            "technical_inspection_center_id" => $this->technical_inspection_center_id,
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
