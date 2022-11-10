<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Files\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class InsuranceCompanyPackage extends Model
{
    use HasFactory, HasFile, HasAds;

    protected $table = 'insurance_company_packages';

    protected $guarded = [];

    protected $hidden = ['name_ar', 'name_en', 'created_at', 'updated_at'];

    protected $appends = ['name', 'price_after_discount'];

    public $timestamps = true;

    //appends start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function getPriceAfterDiscountAttribute()
    {
        if ($this->discount != null) {
            $discount_type = $this->discount_type;
            $percentage_value = ((100 - $this->discount) / 100);
            if ($discount_type == 'percentage') {
                return $price_after_discount = number_format($this->price * $percentage_value,2);
            } else {
                return $price_after_discount = number_format($this->price - $this->discount,2);

            }
        }
        return 0;
    }
    //appends end

    //relations start
    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class);
    }

    public function coverageType()
    {
        return $this->belongsTo(CoverageType::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, InsuranceCompanyPackageFeature::class);
    }

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }
    //relations end

    //scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    //scopes end
}
