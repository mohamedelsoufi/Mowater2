<?php

namespace App\Http\Resources\Ads;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class GetAdsResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["image"] = $this->image;
        $data["title"] = $this->title;
        $data["description"] = $this->description;
        $data["link"] = $this->link;
        $data["organizationable_id"] = $this->organizationable_id;
        $data["organizationable_type"] = $this->organizationable_type;
        if ($request->routeIs('ads.show')){
            $class = $this->organizationable_type;
            $model = new $class;
            $data["organization"] = $model->find($this->organizationable_id);
        }
        $data["module_type"] = $this->module_type;
        $data["module_id"] = $this->module_id;
        if ($request->routeIs('ads.show')){
            $data["module"] = $this->module;
        }
        $data["price"] = $this->price;
        $data["negotiable"] = $this->negotiable;
        $data["ad_type_id"] = $this->adType->name;
        $data["country_id"] = $this->country_id;
        if ($request->routeIs('ads.show')){
            $data["country"] = $this->country;
        }
        $data["city_id"] = $this->city_id;
        if ($request->routeIs('ads.show')){
            $data["city"] = $this->city;
        }
        $data["area_id"] = $this->area_id;
        if ($request->routeIs('ads.show')){
            $data["area"] = $this->area;
        }
        $data["start_date"] = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('d-m-Y H:i A');
        $data["end_date"] = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date)->format('d-m-Y H:i A');
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["number_of_views"] = $this->number_of_views;
        $data["available"] = $this->available;
        $data["active"] = $this->active;
        return $data;
    }
}
