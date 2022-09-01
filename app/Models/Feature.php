<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CoverageType;
use Illuminate\Support\Facades\App;

class Feature extends Model
{
    use HasFactory;
    protected $table = 'features';

    protected $guarded = [];

    protected $hidden = ['name_en', 'name_ar', 'created_at', 'updated_at'];

    protected $appends = ['name'];

    public $timestamps = true;

    //appends//
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    //end of appends

    //relations start
    public function insurance_companies()
    {
        return $this->morphToMany(InsuranceCompany::class, 'usable',InsuranceCompanyUse::class);
    }

    public function brokers()
    {
        return $this->morphToMany(Broker::class, 'usable',BrokerUse::class);
    }

    public function packages(){
        return $this->belongsToMany(InsuranceCompanyPackage::class,InsuranceCompanyPackageFeature::class);
    }

    //relations start
}
