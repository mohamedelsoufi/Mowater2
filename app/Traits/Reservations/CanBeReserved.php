<?php


namespace App\Traits\Reservations;

use App\Models\Reservation;

trait CanBeReserved
{
    public function reservations()
    {
        return $this->morphMany(Reservation::class, 'reservable');
    }
}
