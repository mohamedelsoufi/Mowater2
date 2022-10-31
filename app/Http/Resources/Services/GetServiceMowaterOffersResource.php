<?php

namespace App\Http\Resources\Services;

use Illuminate\Http\Resources\Json\JsonResource;

class GetServiceMowaterOffersResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        if (isset($this->kind)){
            $data["kind"] = $this->kind;
        }
        $data["id"] = $this->id;
        $data["one_image"] = $this->one_image ? $this->one_image : '';
        $data["name"] = $this->name;
        $data["description"] = $this->description;
        $data["servable_type"] = $this->servable_type;
        $data["servable_id"] = $this->servable_id;
        $data["category_id"] = $this->category_id ? $this->category_id : '';
        $data["category"] = $this->category ? $this->category->name : '';
        $data["sub_category_id"] = $this->sub_category_id ? $this->sub_category_id : '';
        $data["sub_category"] = $this->sub_category ? $this->sub_category->name : '';
        $data["location_required"] = $this->location_required ? $this->location_required : '';
        $data["price"] = $this->price;
        $data["card_discount_value"] = $this->card_discount_value;
        $data["card_price_after_discount"] = $this->card_price_after_discount;
        $data["card_number_of_uses_times"] = $this->card_number_of_uses_times;
        $data["notes"] = $this->notes;
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["available"] = $this->available;
        $data["active"] = $this->active;

        return $data;
    }
}
