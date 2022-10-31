<?php

namespace App\Http\Resources\AccessoriesStore;

use Illuminate\Http\Resources\Json\JsonResource;

class GetPurchasesResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [];

        $data["id"] = $this->id;
        $data["accessories_store_id"] = $this->accessories_store_id;
        if ($request->routeIs('accessories-purchase.show')){
            $data["store"] = new GetAccessoriesStoresResource($this->accessoriesStore);

        }
        $data["user_id"] = $this->user_id;
        if ($request->routeIs('accessories-purchase.show')){
            $data["user"] = $this->user;
        }
        $data["accessories"] =  GetAccessoriesResource::collection($this->accessories);
        $data["first_name"] = $this->first_name;
        $data["last_name"] = $this->last_name;
        $data["nickname"] = $this->nickname;
        $data["country_code"] = $this->country_code;
        $data["nationality"] = $this->nationality;
        $data["home_delivery"] = $this->home_delivery;
        $data["address"] = $this->address;
        $data["brand_id"] = $this->brand_id;
        if ($request->routeIs('accessories-purchase.show')){
            $data["brand"] = $this->brand;
        }
        $data["car_model_id"] = $this->car_model_id;
        if ($request->routeIs('accessories-purchase.show')){
            $data["car_model"] = $this->car_model;
        }
        $data["is_mawater_card"] = $this->is_mawater_card;


        return $data;
    }
}
