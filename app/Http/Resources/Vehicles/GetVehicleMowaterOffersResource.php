<?php

namespace App\Http\Resources\Vehicles;

use Illuminate\Http\Resources\Json\JsonResource;

class GetVehicleMowaterOffersResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        if (isset($this->kind)){
            $data["kind"] = $this->kind;
        }
        $data["id"] = $this->id;
        $data["one_image"] = $this->one_image ? $this->one_image : '';
        $data["created_by"] = $this->created_by;
        $data["vehicable_type"] = $this->vehicable_type;
        $data["vehicable_id"] = $this->vehicable_id;
        $data["brand_id"] = $this->brand_id;
        $data["brand"] = $this->brand->name;
        $data["car_model_id"] = $this->car_model_id;
        $data["car_model"] = $this->car_model->name;
        $data["car_class_id"] = $this->car_class_id;
        $data["car_class"] = $this->car_class->name;
        $data["manufacturing_year"] = $this->manufacturing_year;
        $data["engine_size"] = $this->engine_size;
        $data["is_new"] = $this->is_new;
        $data["distance_color"] = $this->distance_color;
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
