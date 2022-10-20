<?php

namespace App\Http\Resources\AccessoriesStore;

use App\Http\Resources\Categories\GetCategoriesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetStoreMawaterOffersResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["one_image"] = $this->one_image;
        $data["name"] = $this->name;
        $data["description"] = $this->description;
        $data["accessories_store_id"] = $this->accessories_store_id;
        $data["store"] = new GetAccessoriesStoresResource($this->accessoriesStore);
        $data["category_id"] = $this->category_id;
        $data["category"] = $this->category->name;
        $data["sub_category_id"] = $this->sub_category_id;
        $data["sub_category"] = $this->SubCategory->name;
        $data["brand_id"] = $this->brand_id;
        $data["brand"] = $this->brand->name;
        $data["car_model_id"] = $this->car_model_id;
        $data["car_model"] = $this->car_model->name;
        $data["guarantee"] = $this->guarantee;
        $data["guarantee_year"] = $this->guarantee_year;
        $data["guarantee_month"] = $this->guarantee_month;
        $data["price"] = $this->price;
        $data["card_discount_value"] = $this->card_discount_value;
        $data["card_price_after_discount"] = $this->card_price_after_discount;
        $data["card_number_of_uses_times"] = $this->card_number_of_uses_times;
        $data["notes"] = $this->notes;
        $data["rating"] = $this->rating;
        $data["rating_count"] = $this->rating_count;
        $data["is_reviewed"] = $this->is_reviewed;
        $data["is_favorite"] = $this->is_favorite;
        $data["favorites_count"] = $this->favorites_count;
        $data["number_of_views"] = $this->number_of_views ? $this->number_of_views : 0;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["available"] = $this->available;
        $data["active"] = $this->active;

        return $data;
    }
}
