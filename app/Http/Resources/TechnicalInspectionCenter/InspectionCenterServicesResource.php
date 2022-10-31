<?php

namespace App\Http\Resources\TechnicalInspectionCenter;

use Illuminate\Http\Resources\Json\JsonResource;

class InspectionCenterServicesResource extends JsonResource
{
    public function toArray($request)
    {

        $data = [];
        $data["id"] = $this->id;
        $data["name"] = $this->name;
        $data["description"] = $this->description;
        $data["one_image"] = $this->one_image;
        $data["technical_inspection_center_id"] = $this->technical_inspection_center_id;
        $data["price"] = $this->price;
        $data["discount"] = $this->discount;
        $data["discount_type"] = $this->discount_type;
        $data["price_after_discount"] = $this->price_after_discount;
        if ($request->routeIs('inspection-centers.show-service','inspection-centers.show')) {
            $data["files"] = $this->files;
        }
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["available"] = $this->available;
        $data["active"] = $this->active;
        return $data;
    }
}
