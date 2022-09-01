<?php

namespace App\Http\Resources\Branches;

use App\Http\Resources\Insurance\InsuranceCompanyPackagesResource;
use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowBranchResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["branchable_type"] = $this->branchable_type;
        $data["branchable_id"] = $this->branchable_id;
        $data["name"] = $this->name;
        $data["address"] = $this->address;
        $data["category_id"] = $this->category_id;
        $data["area_id"] = $this->area_id;
        $data["city_id"] = $this->city_id;
        $data["longitude"] = $this->longitude;
        $data["latitude"] = $this->latitude;
        $data["work_time"] = $this->work_time;
        $data["contact"] = $this->contact;
        $data["phones"] = $this->phones;
        $data["payment_methods"] = GetPaymentMethodsResource::collection($this->payment_methods);
        $data["reservation_availability"] = $this->reservation_availability;
        $data["delivery_availability"] = $this->delivery_availability;
        $data["reviews"] = $this->reviews;
        $data["is_favorite"] = $this->is_favorite;
        $data["favorites_count"] = $this->favorites_count;
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["availability"] = $this->availability;

        return $data;
    }
}
