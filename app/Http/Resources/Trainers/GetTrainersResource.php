<?php

namespace App\Http\Resources\Trainers;

use App\Http\Resources\PaymentMethods\GetPaymentMethodsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetTrainersResource extends JsonResource
{
    public function toArray($request)
    {
        $data =[];

        $data["id"]= $this->id;
        $data["profile"]= $this->profile;
        $data["name"]= $this->name;
        $data["description"]= $this->description;
        $data["gender"]= $this->gender;
        $data["age"]= $this->age;
        $data["birth_date"]= $this->birth_date;
        $data["hour_price"]= $this->hour_price;
        $data["vehicle_type"]= $this->vehicle_type;
        $data["vehicle_image"]= $this->file_url;
        $data["conveyor_type"]= $this->conveyor_type;
        $data["manufacturing_year"]= $this->manufacturing_year;
        $data["brand_id"]=$this->brand_id;
//        if ($request->routeIs('trainers.show')){
            $data["brand"]=$this->brand;
//        }
        $data["car_model_id"]= $this->car_model_id;
//        if ($request->routeIs('trainers.show')){
            $data["car_model"]=$this->car_model;
//        }
        $data["car_class_id"]=$this->car_class_id;
//        if ($request->routeIs('trainers.show')){
            $data["car_class"]=$this->car_class;
//        }

        $data["country_id"]= $this->country_id;
//        if ($request->routeIs('trainers.show')){
            $data["country"]=$this->country;
//        }
        $data["city_id"]= $this->city_id;
//        if ($request->routeIs('trainers.show')){
            $data["city"]= $this->city;
//        }
        $data["area_id"]= $this->area_id;
        if ($request->routeIs('trainers.show')){
            $data["area"]= $this->area;
            $data["work_time"]= $this->work_time;
            $data["contact"] = $this->contact;
            $data["phones"] = $this->phones;
            $data["reviews"]= $this->reviews;
        }
        $data['payment_methods'] =  GetPaymentMethodsResource::collection($this->payment_methods);
        $data["is_reviewed"]= $this->is_reviewed;
        $data["rating"]= $this->rating;
        $data["rating_count"]= $this->rating_count;
        $data['is_favorite'] = $this->is_favorite;
        $data['favorites_count'] = $this->is_favorite;
        $data["number_of_views"]= $this->number_of_views;
        $data["active_number_of_views"]= $this->active_number_of_views;
        $data["active"]= $this->active;
        $data["available"]= $this->available;

        return $data;
    }
}
