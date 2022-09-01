<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory, HasFiles;
    protected $table = 'reservations';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    //relationship start
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function reservable()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_reservation')->withPivot('quantity');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'reservation_service');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    //relationship end

    public function setAddressAttribute($val)
    {
        $this->attributes['address'] = ucfirst($val);
    }

    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? asset('uploads' . $default_image->path) : null ;
    }

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
