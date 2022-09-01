<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryManReservation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['time', 'date'];

    //relations
    public function delivery_man()
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }


    //scopes
    public function setFirstNameAttribute($val)
    {
        $this->attributes['first_name'] = ucwords($val);
    }

    public function setLastNameAttribute($val)
    {
        $this->attributes['last_name'] = ucfirst($val);
    }

    public function setNickNameAttribute($val)
    {
        $this->attributes['nickname'] = ucfirst($val);
    }
}
