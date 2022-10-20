<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryArea extends Model
{
    use HasFactory;

    protected $table = 'delivery_areas';

    protected $guarded = [];

    protected $hidden = ['created_at','updated_at'];

    public $timestamps = true;

    // relations start
    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    // relations end
}
