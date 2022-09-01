<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Files\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class BrokerPackage extends Model
{
    use HasFactory, HasFile,HasAds;

    protected $table = 'broker_packages';

    protected $fillable = ['id','name_en','name_ar','broker_id','coverage_type_id','price','discount','discount_type','active'];

    protected $hidden = ['name_ar', 'name_en', 'created_at', 'updated_at'];

    protected $appends = ['name','price_after_discount'];

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
                return $price_after_discount = $this->price * $percentage_value;
            } else {
                return $price_after_discount = $this->price - $this->discount;

            }
        }
        return 0;
    }
    //appends end

    //relations start
    public function broker()
    {
        return $this->belongsTo(Broker::class);
    }

    public function coverageType()
    {
        return $this->belongsTo(CoverageType::class);
    }

    public function features(){
        return $this->belongsToMany(Feature::class,BrokerPackageFeature::class);
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
