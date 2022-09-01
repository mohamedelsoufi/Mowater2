<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestInsurance extends Model
{
    use HasFactory, HasFiles;
    protected $table = 'request_insurances';
    protected $guarded = [];

    public function brokers()
    {
        return $this->morphedByMany(Broker::class, 'organizationable', 'request_insurance_organization')->withPivot('status', 'price');
    }

    public function insurance_companies()
    {
        return $this->morphedByMany(InsuranceCompany::class, 'organizationable', 'request_insurance_organization')->withPivot('status', 'price');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
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
