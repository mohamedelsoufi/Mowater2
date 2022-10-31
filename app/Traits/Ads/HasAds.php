<?php

namespace App\Traits\Ads;

use App\Models\Ad;

trait HasAds
{
    public function ads()
    {
        return $this->morphMany(Ad::class, 'organizationable');
    }

    public function adsOn()
    {
        return $this->morphMany(Ad::class, 'module');
    }
}
