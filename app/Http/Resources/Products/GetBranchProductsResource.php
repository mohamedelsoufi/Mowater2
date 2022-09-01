<?php

namespace App\Http\Resources\Products;

use App\Models\Agency;
use App\Models\Branch;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class GetBranchProductsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "productable_type" => $this->productable_type,
            "productable_id" => $this->productable_id,
            "name" => $this->name,
            "description" => $this->description,
            "image" => $this->one_image,
            "brand_id" => $this->brand_id,
            "car_model_id" => $this->car_model_id,
            "car_class_id" => $this->car_class_id,
            "manufacturing_year" => $this->manufacturing_year,
            "engine_size" => $this->engine_size,
            "price" => $this->price,
            "discount" => $this->discount,
            "discount_type" => $this->discount_type,
            "price_after_discount" => $this->price_after_discount,
            "category_id" => $this->category_id,
            "category" => $this->category,
            "sub_category_id" => $this->sub_category_id,
            "sub_category" => $this->sub_category,
            "warranty_value" => $this->warranty_value,
            "status" => $this->status,
            "type" => $this->type,
            "is_new" => $this->is_new,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "active" => $this->active,
            "available" => $this->available,
        ];
    }
}
