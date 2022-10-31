<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestTechnicalInspection extends Model
{
    use HasFactory;

    protected $table = 'request_technical_inspections';

    protected $fillable = ['id', 'user_id', 'technical_inspection_center_id', 'first_name', 'last_name', 'nickname', 'nationality',
        'country_code', 'phone', 'brand_id', 'car_model_id', 'car_class_id', 'manufacturing_year',
        'chassis_number', 'number_plate', 'is_mawater_card', 'price', 'date', 'time', 'status',];

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = true;

    //relationship start
    public function inspectionCenter()
    {
        return $this->belongsTo(TechnicalInspectionCenter::class, 'technical_inspection_center_id');
    }

    public function inspectionCenterService()
    {
        return $this->belongsToMany(TechnicalInspectionCenterService::class, 'inspection_center_request_services');
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
