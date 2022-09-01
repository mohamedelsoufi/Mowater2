<?php

namespace App\Http\Resources\SpecialNumbers;

use Illuminate\Http\Resources\Json\JsonResource;

class GetSpecialNumberOrganizationsResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["logo"] = $this->logo;
        $data["name"] = $this->name;
        $data["description"] = $this->description;
        $data["tax_number"] = $this->tax_number;
        $data["year_founded"] = $this->year_founded;
        $data["country_id"] = $this->country_id;
        if ($request->routeIs('special-org.show')){
            $data["country"] = $this->country;
        }
        $data["city_id"] = $this->city_id;
        if ($request->routeIs('special-org.show')){
            $data["city"] = $this->city;
        }
        $data["area_id"] = $this->area_id;
        if ($request->routeIs('special-org.show')){
            $data["area"] = $this->area;
            $data["specia_numbers"] = AllSpecialNumbersResource::collection($this->special_numbers);
        }
        $data["rating"] = $this->rating;
        $data["rating_count"] = $this->rating_count;
        $data["is_reviewed"] = $this->is_reviewed;
        $data["is_favorite"] = $this->is_favorite;
        $data["favorites_count"] = $this->favorites_count;
        if ($request->routeIs('special-org.show')){
            $data["reviews"] = $this->review;
        }
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["reservation_availability"] = $this->reservation_availability;
        $data["delivery_availability"] = $this->delivery_availability;
        $data["reservation_active"] = $this->reservation_active;
        $data["delivery_active"] = $this->delivery_active;
        $data["active"] = $this->active;
        $data["available"] = $this->available;

        return $data;
    }
}
