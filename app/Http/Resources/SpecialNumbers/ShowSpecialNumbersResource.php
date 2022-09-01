<?php

namespace App\Http\Resources\SpecialNumbers;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowSpecialNumbersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "category_id" => $this->category_id,
            "category" => $this->category,
            "sub_category_id" => $this->sub_category_id,
            "sub_category" => $this->sub_category,
            "number" => $this->number,
            "is_special" => $this->is_special,
            "size" => $this->size,
            "transfer_type" => $this->transfer_type,
            "price" => $this->price,
            "discount" => $this->discount,
            "price_after_discount" => $this->price_after_discount,
            "price_include_transfer" => $this->price_include_transfer,
            "user_id" => $this->user_id,
            "user" => $this->user,
            "special_number_organization_id" => $this->special_number_organization_id,
            "special_number_organization" => $this->special_number_organization,
            "payment_methods" => GetPaymentMethodsResource::collection($this->payment_methods),
            'rating' => $this->rating,
            'rating_count' => $this->rating_count,
            'is_reviewed' => $this->is_reviewed,
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "availability" => $this->availability,
        ];
    }
}
