<?php

namespace App\Http\Resources\Scraps;

use App\Http\Resources\Reviews\ShowReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetScrapsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "logo" => $this->logo,
            "name" => $this->name,
            "description" => $this->description,
            "country_id" => $this->country_id,
            "city_id" => $this->city_id,
            "area_id" => $this->area_id,
            "year_founded" => $this->year_founded,
            "rating" => $this->rating,
            "rating_count" => $this->rating_count,
            "is_reviewed" => $this->is_reviewed,
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "reviews" => ShowReviewResource::collection($this->reviews),
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "reservation_availability" => $this->reservation_availability,
            "delivery_availability" => $this->delivery_availability,
            "active" => $this->active,
            "available" => $this->available,
        ];
    }
}
