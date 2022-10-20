<?php

namespace App\Http\Resources\Delivery;

use App\Http\Resources\Categories\GetCategoriesResource;
use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetDeliveriesResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["profile"] = $this->profile;
        $data["name"] = $this->name;
        $data["description"] = $this->description;
        $data["gender"] = $this->gender;
        $data["age"] = $this->age;
        $data["birth_date"] = $this->birth_date;


        $data["vehicle_image"] = $this->file_url;
        $data["driving_license"] = $this->file()->where('type','driving_license')->first()->path;
        $data["vehicle_type"] = $this->vehicle_type;

        $data["brand_id"] = $this->brand_id;
        if ($request->routeIs('deliveries.show')){
            $data["brand"]=$this->brand;
        }
        $data["car_model_id"] = $this->car_model_id;
        if ($request->routeIs('deliveries.show')){
            $data["car_model"]=$this->car_model;
        }
        $data["car_class_id"] = $this->car_class_id;
        if ($request->routeIs('deliveries.show')){
            $data["car_class"]=$this->car_class;
        }
        $data["manufacturing_year"] = $this->manufacturing_year;
        $data["country_id"] = $this->country_id;
        if ($request->routeIs('deliveries.show')){
            $data["country"]=$this->country;
        }
        $data["city_id"] = $this->city_id;
        if ($request->routeIs('deliveries.show')){
            $data["city"]=$this->city;
        }
        $data["area_id"] = $this->area_id;
        if ($request->routeIs('deliveries.show')){
            $data["area"]= $this->area;
            $data["delivery_types"] = GetCategoriesResource::collection($this->categories);

            $data["work_time"]= $this->work_time;
            $data["contact"] = $this->contact;
            $data["phones"] = $this->phones;
            $data["reviews"]= $this->reviews;
            $data["day_offs"] = $this->day_offs;
            $data["conditions"] = $this->conditions;
            $data["deliver_to"] = GetDeliveryAreasResource::collection($this->deliveryAreas);
        }
        $data['payment_methods'] =  GetPaymentMethodsResource::collection($this->payment_methods);
        $data["is_reviewed"] = $this->is_reviewed;
        $data["rating"] = $this->rating;
        $data["rating_count"] = $this->rating_count;
        $data['is_favorite'] = $this->is_favorite;
        $data['favorites_count'] = $this->is_favorite;
        $data["number_of_views"] = $this->number_of_views;
        $data["active_number_of_views"] = $this->active_number_of_views;
        $data["status"] = $this->status;
        $data["active"]= $this->active;
        $data["available"]= $this->available;

        return $data;
    }
}
