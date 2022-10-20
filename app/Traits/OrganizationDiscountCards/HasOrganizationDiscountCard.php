<?php

namespace App\Traits\OrganizationDiscountCards;


use App\Models\DiscountCard;
use App\Models\DiscountCardOrganization;

trait HasOrganizationDiscountCard
{
    public function discount_cards()
    {
        return $this->morphToMany(DiscountCard::class, 'organizable' , DiscountCardOrganization::class)->withTimestamps();
    }
}
