<?php

namespace App\Http\Resources\DiscountCards;

use App\Models\DiscountCardOrganization;
use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowDiscountCardResource extends JsonResource
{
    public function toArray($request)
    {
        $org = "App\\Models\\" . $request->organizable_type;
        $organizations = DiscountCardOrganization::where('discount_card_id', $this->id)
            ->where('organizable_type', $org)->get();
        $org_name = [];
        foreach ($organizations as $organization) {
            $model_type = $organization->organizable_type;
            $model_id = $organization->organizable_id;
            $model = new $model_type;
            $get_organization = $model->find($model_id);
            $org_name[] = [
                'id' => $get_organization->id,
                'logo' => $get_organization->logo,
                'name' => $get_organization->name,
                'model_type' => $organization->organizable_type,
            ];
        }
        $discount_card_price = $this->price;
        $created_month = $this->created_at->format('m');
        $price_per_month = $discount_card_price / 12;

        $months = 12 - (int)$created_month;

        $final_price = $price_per_month * $months;

        $dc_organizations = DiscountCardOrganization::where('discount_card_id', $this->id)->get()->unique('organizable_type');
        $dc_org_name = [];
        foreach ($dc_organizations as $dc_organization){
            $org_dc_name = str_replace('App\\Models\\','',$dc_organization->organizable_type);

            $dc_org_name[] = [
                'name' => $org_dc_name,
                'count' => DiscountCardOrganization::where('discount_card_id', $this->id)->where('organizable_type',$dc_organization->organizable_type)->count(),
            ];
        }
        return [
            "id" => $this->id,
            "image" => $this->image,
            "title" => $this->title,
            "description" => $this->description,
            "price" => $this->price,
            "price_now" => $final_price,
            "year" => $this->year,
            "number_of_views" => $this->number_of_views,
            "active_number_of_views" => $this->active_number_of_views,
            "status" => $this->status,
            "active" => $this->active,
            'org_count'=>$dc_org_name,
            "organizations" => $org_name,
        ];
    }
}
