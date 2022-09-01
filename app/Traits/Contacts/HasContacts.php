<?php


namespace App\Traits\Contacts;

trait HasContacts
{

    public function contact()
    {
        return $this->morphOne('App\Models\Contact', 'contactable');
    }

}
