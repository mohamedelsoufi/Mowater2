<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokerReservation extends Model
{
    use HasFactory, HasFiles;
    protected $table = 'broker_reservations';

    protected $guarded = [];

    protected $hidden = ['created_at','updated_at'];

    public $timestamps = true;

    //relations
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function coverage_type()
    {
        return $this->belongsTo(CoverageType::class);
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


    //scopes
    public function getNoAccidentCertificate()
    {
        return $this->no_accident_certificate ?  __('words.doesnot_exist') :__('words.exist') ;
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
