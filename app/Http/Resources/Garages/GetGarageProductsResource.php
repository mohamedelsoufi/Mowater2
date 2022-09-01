<?php

namespace App\Http\Resources\Garages;

use Illuminate\Http\Resources\Json\JsonResource;

class GetGarageProductsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "productable_type" => $this->productable_type,
            "productable_id" => $this->productable_id,
            "image" => $this->one_image,
            "name" => $this->name,
            "description" => $this->description,
            "brand_id" => $this->brand_id,
            "car_model_id" => $this->car_model_id,
            "car_class_id" => $this->car_class_id,
            "manufacturing_year" => $this->manufacturing_year,
            "engine_size" => $this->engine_size,
            "category_id" => $this->category_id,
            "sub_category_id" => $this->sub_category_id,
            "status" => $this->status,
            "type" => $this->type,
            "is_new" => $this->is_new,
            "warranty_value" => $this->warranty_value,
            "price" => $this->price,
            "discount" => $this->discount,
            "discount_type" => $this->discount_type,
            "price_after_discount" => $this->price_after_discount,
            "files" => $this->files,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "available" => $this->available,
            "active" => $this->active,

        ];
    }
}
