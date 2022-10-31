<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReserveInsuranceCompanyService extends Model
{
    use HasFactory, HasFiles;

    protected $table = 'reserve_insurance_company_services';

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
