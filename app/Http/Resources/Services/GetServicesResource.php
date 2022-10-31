<?php

namespace App\Http\Resources\Services;

use App\Models\Agency;
use App\Models\Branch;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class GetServicesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "servable_type" => $this->servable_type,
            "servable_id" => $this->servable_id,
            "name" => $this->name,
            "description" => $this->description,
            "image" => $this->one_image,
            "category_id" => $this->category_id,
            "category" => $this->category,
            "sub_category_id" => $this->sub_category_id,
            "sub_category" => $this->sub_category,
            "price" => $this->price,
            "discount" => $this->discount,
            "discount_type" => $this->discount_type,
            "price_after_discount" => $this->price_after_discount,
            "location_required" => $this->location_required,
            "branches" => branchInUse('Agency', 'App\\Models\\Service', $this->id),
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "active" => $this->active,
            "available" => $this->available,

        ];
    }
}
