<?php

namespace App\Http\Resources\Vehicles;

use App\Http\Resources\Users\GetUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class GetVehiclesForSaleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "vehicable_id" => $this->vehicable_id,
            "vehicable_type" => $this->vehicable_type,
            "user" => new GetUserResource($this->vehicable),
            "one_image" => $this->one_image,
            "vehicle_type" => $this->vehicle_type,
            "brand_id" => $this->brand_id,
            "car_model_id" => $this->car_model_id,
            "car_class_id" => $this->car_class_id,
            "manufacturing_year" => $this->manufacturing_year,
            "is_new" => $this->is_new,
            "price" => $this->price,
            "distance_color" => $this->distance_color,
            "price_after_discount" => $this->price_after_discount,
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "time" => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y H:i A'),
            "active_number_of_views" => $this->active_number_of_views,
            "number_of_views" => $this->number_of_views,
            "availability" => $this->availability,
            "active" => $this->active,
        ];
    }
}
