<?php

namespace App\Http\Resources\Branches;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetBranchesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "branchable_type" => $this->branchable_type,
            "branchable_id" => $this->branchable_id,
            "name" => $this->name,
            "address" => $this->address,
            "category_id" => $this->category_id,
            "area_id" => $this->area_id,
            "city_id" => $this->city_id,
            "country_id" => $this->country_id,
            "longitude" => $this->longitude,
            "latitude" => $this->latitude,
            "reservation_availability" => $this->reservation_availability,
            "delivery_availability" => $this->delivery_availability,
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "payment_methods" => GetPaymentMethodsResource::collection($this->payment_methods),
            "contacts" => $this->contact,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "availability" => $this->availability,
        ];
    }
}
