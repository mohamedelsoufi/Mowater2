<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CoverageType extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['name_en', 'name_ar', 'created_at', 'updated_at'];
    protected $appends = ['name'];
    protected $table='coverage_types';

    //appends//
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    //end of appends

    //relations
    public function insurance_companies()
    {
        return $this->morphedByMany(InsuranceCompany::class, 'coveragable');
    }

    public function insuranceReservations()
    {
        return $this->hasMany(ReserveInsuranceCompanyService::class);
    }

//    public function features()
//    {
//        return $this->hasMany(Feature::class);
//    }
}
