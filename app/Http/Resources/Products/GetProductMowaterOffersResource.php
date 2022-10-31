<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class GetProductMowaterOffersResource extends JsonResource
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
        $data["productable_type"] = $this->productable_type;
        $data["productable_id"] = $this->productable_id;
        $data["brand_id"] = $this->brand_id;
        $data["brand"] = $this->brand->name;
        $data["car_model_id"] = $this->car_model_id;
        $data["car_model"] = $this->car_model->name;
        $data["car_class_id"] = $this->car_class_id;
        $data["car_class"] = $this->car_class->name;
        $data["manufacturing_year"] = $this->manufacturing_year;
        $data["engine_size"] = $this->engine_size;
        $data["status"] = $this->status;
        $data["type"] = $this->type;
        $data["is_new"] = $this->is_new;
        $data["category_id"] = $this->category_id ? $this->category_id : '';
        $data["category"] = $this->category ? $this->category->name : '';
        $data["sub_category_id"] = $this->sub_category_id ? $this->sub_category_id : '';
        $data["sub_category"] = $this->sub_category ? $this->sub_category->name : '';
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
