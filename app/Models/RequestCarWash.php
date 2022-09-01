<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCarWash extends Model
{
    use HasFactory;

    protected $table = 'request_car_washes';

    protected $fillable = ['id', 'user_id', 'car_wash_id', 'first_name', 'last_name', 'nickname', 'nationality',
        'country_code', 'phone', 'brand_id', 'car_model_id', 'car_class_id', 'manufacturing_year',
        'chassis_number', 'number_plate', 'is_mawater_card', 'price', 'date', 'time', 'status',];

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = true;

    //relationship start
    public function carWash()
    {
        return $this->belongsTo(CarWash::class, 'car_wash_id');
    }

    public function carWashServices()
    {
        return $this->belongsToMany(CarWashService::class, 'car_wash_request_services');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function car_class()
    {
        return $this->belongsTo(CarClass::class);
    }

    public function car_model()
    {
        return $this->belongsTo(CarModel::class);
    }
    //relationship end

    // accessors & Mutator start
    public function setFirstNameAttribute($val)
    {
        $this->attributes['first_name'] = ucwords($val);
    }

    public function setLastNameAttribute($val)
    {
        $this->attributes['last_name'] = ucwords($val);
    }

    public function setNickNameAttribute($val)
    {
        $this->attributes['nickname'] = ucwords($val);
    }

    public function setNationalityAttribute($val)
    {
        $this->attributes['nationality'] = ucwords($val);
    }
    // accessors & Mutator end

}
