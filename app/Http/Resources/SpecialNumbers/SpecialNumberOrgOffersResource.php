<?php

namespace App\Http\Resources\SpecialNumbers;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecialNumberOrgOffersResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "category_id" => $this->category_id,
            "sub_category_id" => $this->sub_category_id,
            "number" => $this->number,
            "is_special" => $this->is_special,
            "size" => $this->size,
            "transfer_type" => $this->transfer_type,
            "price" => $this->price,
            "discount" => $this->discount,
            "price_after_discount" => $this->price_after_discount,
            "price_include_transfer" => $this->price_include_transfer,
            "card_discount_value"=>$this-> card_discount_value,
            "card_number_of_uses_times"=>$this-> card_number_of_uses_times,
            "user_id" => $this->user_id,
            "special_number_organization_id" => $this->special_number_organization_id,
            'rating' => $this->rating,
            'rating_count' => $this->rating_count,
            'is_reviewed' => $this->is_reviewed,
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "availability" => $this->availability,
            "mawater_discount_type" => $this->mawater_discount_type,
            "price_after_mawater_discount" => $this->price_after_mawater_discount,
            "notes" => $this->notes,
        ];
    }
}
