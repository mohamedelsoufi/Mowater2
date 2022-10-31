<?php

namespace App\Traits\Vehicles;

use App\Models\MainVehicle;
use App\Models\Vehicle;

trait HasVehicles
{
    public function vehicles()
    {
        return $this->morphMany(Vehicle::class, 'vehicable');
    }
}
