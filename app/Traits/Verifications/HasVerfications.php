<?php


namespace App\Traits\Verifications;

trait HasVerfications
{
    public function verifications()
    {
        return $this->morphToMany('App\Models\User', 'model', 'verifications')->withPivot('status');
    }
}
