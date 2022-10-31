<?php

namespace App\Http\Resources\Garages;

use Illuminate\Http\Resources\Json\JsonResource;

class GetGarageServicesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "servable_type" => $this->servable_type,
            "servable_id" => $this->servable_id,
            "image" => $this->one_image,
            "name" => $this->name,
            "description" => $this->description,
            "category_id" => $this->category_id,
            "sub_category_id" => $this->sub_category_id,
            "location_required" => $this->location_required,
            "price" => $this->price,
            "discount" => $this->discount,
            "discount_type" => $this->discount_type,
            "price_after_discount" => $this->price_after_discount,
            "files" => $this->files,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "active" => $this->active,
            "available" => $this->available,

        ];
    }
}
