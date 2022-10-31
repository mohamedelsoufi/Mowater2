<?php

namespace App\Http\Resources\TechnicalInspectionCenter;

use Illuminate\Http\Resources\Json\JsonResource;

class InspectionCenterMowaterOffersResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "one_image" => $this->one_image,
            "name" => $this->name,
            "description" => $this->description,
            "technical_inspection_center_id" => $this->technical_inspection_center_id,
            "technical_inspection_center" => $this->inspectionCenter->name,
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
