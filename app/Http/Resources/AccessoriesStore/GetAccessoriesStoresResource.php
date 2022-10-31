<?php

namespace App\Http\Resources\AccessoriesStore;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use App\Http\Resources\Reviews\ShowReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAccessoriesStoresResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];
        $data["id"] = $this->id;
        $data["logo"] = $this->logo;
        $data["name"] = $this->name;
        $data["description"] = $this->description;
        $data["tax_number"] = $this->tax_number;
        $data["address"] = $this->address;
        $data["city_id"] = $this->city_id;
        $data["city"] = $this->city;
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data['payment_methods'] =  GetPaymentMethodsResource::collection($this->payment_methods);
        $data['contact'] = $this->contact;
        $data['work_time'] = $this->work_time;
        $data["rating"] = $this->rating;
        $data["rating_count"] = $this->rating_count;
        $data["is_reviewed"] = $this->is_reviewed;
        $data["is_favorite"] = $this->is_favorite;
        $data["favorites_count"] = $this->favorites_count;
        if ($request->routeIs('accessories-store.show')){
            $data["reviews"] = ShowReviewResource::collection($this->reviews);
        }
        $data["reservation_availability"] = $this->reservation_availability;
        $data["reservation_active"] = $this->reservation_active;
        $data["delivery_availability"] = $this->delivery_availability;
        $data["delivery_active"] = $this->delivery_active;
        $data["available"] = $this->available;
        $data["active"] = $this->active;
        return $data;
    }
}
