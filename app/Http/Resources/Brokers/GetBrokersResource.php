<?php

namespace App\Http\Resources\Brokers;

use App\Http\Resources\Branches\GetBranchesResource;
use App\Http\Resources\CoverageTypes\GetCoverageTypesResource;
use App\Http\Resources\Features\GetFeaturesResource;
use App\Http\Resources\Laws\GetLawsResource;
use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetBrokersResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        $data['id'] = $this->id;
        $data['logo'] = $this->logo;
        $data['name'] = $this->name;
        $data['description'] = $this->description;
//        if ($request->routeIs('brokers.show')){
//            $data['requirements'] = $this->requirements;
//        }
        $data['tax_number'] = $this->tax_number;
        $data['year_founded'] = $this->year_founded;
        $data['country_id'] = $this->country_id;
        if ($request->routeIs('brokers.show')) {
            $data['country'] = $this->country;
        }
        $data['city_id'] = $this->city_id;
        if ($request->routeIs('brokers.show')) {
            $data['city'] = $this->city;
        }
        $data['area_id'] = $this->area_id;
        if ($request->routeIs('brokers.show')) {
            $data['area'] = $this->area;
        }
        if ($request->routeIs('brokers.show')) {
            $data['packages'] = BrokerPackagesResource::collection($this->packages);
            $data['laws'] = GetLawsResource::collection($this->laws);
            $data['branches'] = GetBranchesResource::collection($this->branches);
        }
        $data['payment_methods'] = GetPaymentMethodsResource::collection($this->payment_methods);
        $data["work_time"] = $this->work_time;
        $data["contact"] = $this->contact;
        $data["phones"] = $this->phones;
        $data['is_reviewed'] = $this->is_reviewed;
        $data['reviews'] = $this->reviews;
        $data['rating'] = $this->rating;
        $data['rating_count'] = $this->rating_count;
        $data['is_favorite'] = $this->is_favorite;
        $data['favorites_count'] = $this->is_favorite;
        $data['number_of_views'] = $this->number_of_views;
        $data['active_number_of_views'] = $this->active_number_of_views;
        $data['reservation_availability'] = $this->reservation_availability;
        $data['reservation_active'] = $this->reservation_active;
        $data['available'] = $this->available;
        $data['active'] = $this->active;

        return $data;
    }
}
