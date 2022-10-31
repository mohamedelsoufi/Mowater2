<?php

namespace App\Http\Resources\MiningCenter;

use Illuminate\Http\Resources\Json\JsonResource;

class GetMiningCenterServicesResource extends JsonResource
{
    public function toArray($request)
    {

        $data = [];
        $data["id"] = $this->id;
        $data["name"] = $this->name;
        $data["description"] = $this->description;
        $data["one_image"] = $this->one_image;
        $data["mining_center_id"] = $this->mining_center_id;
        $data["price"] = $this->price;
        $data["discount"] = $this->discount;
        $data["discount_type"] = $this->discount_type;
        $data["price_after_discount"] = $this->price_after_discount;
        if ($request->routeIs('mining-centers.show-service','mining-centers.show')) {
            $data["files"] = $this->files;
        }
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["available"] = $this->available;
        $data["active"] = $this->active;
        return $data;
    }
}
