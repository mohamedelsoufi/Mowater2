<?php

namespace App\Http\Resources\Vehicles;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileVehiclesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "vehicable_id" => $this->vehicable_id,
            "vehicable_type" => $this->vehicable_type,
            "brand_id" => $this->brand_id,
            "brand" => $this->brand,
            "car_model_id" => $this->car_model_id,
            "car_model" => $this->car_model,
            "car_class_id" => $this->car_class_id,
            "car_class" => $this->car_class,
            "manufacturing_year" => $this->manufacturing_year,
            "price" => $this->price,
            "price_after_discount" => $this->price_after_discount,
            "vehicle_name" => $this->vehicle_name,
            "wheel_size" => $this->wheel_size,
            "number_plate" => $this->number_plate,
            "chassis_number" => $this->chassis_number,
            "battery_size" => $this->battery_size,
            "maintenance_history" => $this->maintenance_history,
            "maintenance_history_km" => $this->maintenance_history_km,
            "tire_installation_date" => $this->tire_installation_date,
            "tire_installation_date_km" => $this->tire_installation_date_km,
            "tire_warranty_expiration_date" => $this->tire_warranty_expiration_date,
            "tire_warranty_expiration_date_km" => $this->tire_warranty_expiration_date_km,
            "battery_installation_date" => $this->battery_installation_date,
            "battery_installation_date_km" => $this->battery_installation_date_km,
            "battery_warranty_expiry_date" => $this->battery_warranty_expiry_date,
            "battery_warranty_expiry_date_km" => $this->battery_warranty_expiry_date_km,
            "vehicle_registration_expiry_date" => $this->vehicle_registration_expiry_date,
            "vehicle_registration_expiry_date_km" => $this->vehicle_registration_expiry_date_km,
            "vehicle_insurance_expiry_date" => $this->vehicle_insurance_expiry_date,
            "vehicle_insurance_expiry_date_km" => $this->vehicle_insurance_expiry_date_km,
            "additional_maintenance" => $this->additional_maintenance_history,
            "time" => $this->time,
            "distance_color" => $this->distance_color,
            "one_image" => $this->one_image,
            "is_favorite" => $this->is_favorite,
            "favorites_count" => $this->favorites_count,
            "files" => $this->files,
            "availability" => $this->availability,
            "active" => $this->active,
        ];
    }
}
