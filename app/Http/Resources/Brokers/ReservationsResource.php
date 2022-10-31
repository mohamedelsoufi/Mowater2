<?php

namespace App\Http\Resources\Brokers;

use App\Models\Feature;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationsResource extends JsonResource
{
    public function toArray($request)
    {
        $features = array_map('intval', explode(',', $this->features));
        $data = [];

        $data['id'] = $this->id;
        $data['user_id'] = $this->user_id;
        $data['first_name'] = $this->first_name;
        $data['last_name'] = $this->last_name;
        $data['nickname'] = $this->nickname;
        $data['country_code'] = $this->country_code;
        $data['phone'] = $this->phone;
        $data['birth_date'] = $this->birth_date;
        $data['nationality'] = $this->nationality;
        $data['branch_id'] = $this->branch_id;
        $data['branch'] = $this->branch->name;

        $data['service_type'] = __('words.' . $this->service_type);
        $data['package_id'] = $this->package_id;
        $data['package'] = new BrokerPackagesResource($this->package);
        $data['brand_id'] = $this->brand_id;
        $data['brand'] = $this->brand->name;
        $data['car_model_id'] = $this->car_model_id;
        $data['car_model'] = $this->car_model->name;
        $data['car_class_id'] = $this->car_class_id;
        $data['car_class'] = $this->car_class->name;
        $data['manufacturing_year'] = $this->manufacturing_year;
        $data['chassis_number'] = $this->chassis_number;
        $data['number_plate'] = $this->number_plate;
        $data['engine_size'] = $this->engine_size;
        $data['number_of_cylinders'] = $this->number_of_cylinders;
        $data['vehicle_value'] = $this->vehicle_value;
        $data['driving_license_for_insurance'] = $this->files()->where('type', 'driving_license_for_broker')->first()->path;
        $data['vehicle_ownership'] = $this->files()->where('type', 'vehicle_ownership_for_broker')->first()->path;
        if (!empty($this->files()->where('type', 'no_accident_certificate')->first())) {
            $data['no_accident_certificate'] = $this->files()->where('type', 'no_accident_certificate_for_broker')->first()->path;
        }

        return $data;
    }
}
