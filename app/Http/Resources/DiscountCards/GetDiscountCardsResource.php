<?php

namespace App\Http\Resources\DiscountCards;

use App\Models\DiscountCardOrganization;
use Illuminate\Http\Resources\Json\JsonResource;

class GetDiscountCardsResource extends JsonResource
{
    public function toArray($request)
    {
        $organizations = DiscountCardOrganization::where('discount_card_id', $this->id)->active()->get();
        $org_name = [];
        foreach ($organizations as $organization) {
            $model_type = $organization->organizable_type;
            $model_id = $organization->organizable_id;
            $model = new $model_type;
            $get_organization = $model->find($model_id);
            $org_name[] = [
                'id' => $get_organization->id,
                'name' => $get_organization->name,
                'logo' => $get_organization->logo
            ];
        }
        return [
            "id"=>$this-> id,
            "image"=>$this-> image,
            "title"=>$this->title,
            "description"=>$this-> description,
            "price"=>$this-> price,
            "year"=>$this->year,
            "number_of_views"=>$this-> number_of_views,
            "active_number_of_views"=>$this-> active_number_of_views,
            "status"=>$this->status,
            "active"=>$this-> active,
            "organizations"=>$org_name

        ];
    }
}
