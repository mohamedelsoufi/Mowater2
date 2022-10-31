<?php

namespace App\Http\Resources\SpecialNumbers;

use App\Http\Resources\Users\GetUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialNumberOrgMowaterOffersResource extends JsonResource
{

    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["category_id"] = $this->category_id;
        $data["sub_category_id"] = $this->sub_category_id;
        $data["number"] = $this->number;
        $data["is_special"] = $this->is_special;
        $data["size"] = $this->size;
        $data["transfer_type"] = $this->transfer_type;
        $data["price"] = $this->price;
        $data["price_include_transfer"] = $this->price_include_transfer;
        $data["card_discount_value"] = $this->card_discount_value;
        $data["card_price_after_discount"] = $this->card_price_after_discount;
        $data["card_number_of_uses_times"] = $this->card_number_of_uses_times;
        $data["notes"] = $this->notes;
        $data["special_number_organization_id"] = $this->special_number_organization_id ?  $this->special_number_organization_id : '';
        $data["special_number_organization"] = $this->special_number_organization ? $this->special_number_organization->name : '';
        $data['rating'] = $this->rating;
        $data['rating_count'] = $this->rating_count;
        $data['is_reviewed'] = $this->is_reviewed;
        $data["is_favorite"] = $this->is_favorite;
        $data["favorites_count"] = $this->favorites_count;
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["availability"] = $this->availability;
        return $data;
    }
}
