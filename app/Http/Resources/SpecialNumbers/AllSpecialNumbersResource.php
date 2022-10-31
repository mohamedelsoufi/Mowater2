<?php

namespace App\Http\Resources\SpecialNumbers;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AllSpecialNumbersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["category_id"] = $this->category_id;
        $data["sub_category_id"] = $this->sub_category_id;
        $data["number"] = $this->number;
        $data["is_special"] = $this->is_special;
        $data["size"] = $this->size;
        $data["transfer_type"] = $this->transfer_type;
        $data["price"] = $this->price;
        $data["user_id"] = $this->user_id;
        $data["user"] = $this->user;
        $data["special_number_organization_id"] = $this->special_number_organization_id;
        if (!$request->routeIs('special-org.show')) {
            $data["special_number_organization"] = $this->special_number_organization;
        }
        $data["price_include_transfer"] = $this->price_include_transfer;
        $data["payment_methods"] = GetPaymentMethodsResource::collection($this->payment_methods);
        $data['rating'] = $this->rating;
        $data['rating_count'] = $this->rating_count;
        $data['is_reviewed'] = $this->is_reviewed;
        $data["is_favorite"] = $this->is_favorite;
        $data["favorites_count"] = $this->favorites_count;
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["availability"] = $this->availability;

        return $data;
    }
}
