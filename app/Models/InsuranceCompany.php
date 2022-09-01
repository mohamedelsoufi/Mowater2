<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Branches\HasBranches;
use App\Traits\Contacts\HasContacts;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\OrganizationDiscountCards\HasOrganizationDiscountCard;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Reviews\HasReviews;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Traits\Phones\HasPhones;
use App\Traits\OrganizationUsers\HasOrgUsers;

class InsuranceCompany extends Model
{
    use HasDayoffs, HasWorkTimes, HasReviews, CanBeFavourites, HasContacts, HasFactory, HasAds, HasPhones,
        HasOrgUsers, HasOrganizationDiscountCard, HasBranches,HasPaymentMethods;
    protected $guarded = [];
    protected $hidden = ['name_en', 'name_ar', 'description_en', 'description_ar', 'created_at', 'updated_at'];
    protected $appends = ['name', 'description', 'is_reviewed', 'rating', 'rating_count', 'is_favorite','favorites_count'];

    //appends//
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->description_ar;
        }
        return $this->description_en;
    }
    //end of appends

    //relations start
    public function request_insurance_organizations()
    {
        return $this->morphToMany(RequestInsurance::class, 'organizationable', 'request_insurance_organization')->withPivot('status', 'price');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

//    public function coverage_types()
//    {
//        return $this->morphedByMany(CoverageType::class, 'usable', 'insurance_company_uses');
//    }
//
//    public function features()
//    {
//        return $this->morphedByMany(Feature::class, 'usable', 'insurance_company_uses');
//    }

    public function laws()
    {
        return $this->morphMany(Law::class, 'lawable');
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function packages()
    {
        return $this->hasMany(InsuranceCompanyPackage::class);
    }
    //relations end

    //scopes
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
    }

    public function scopeSearch($query)
    {
        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%')
                ->orWhere('description_ar', 'like', '%' . request()->search . '%')
                ->orWhere('description_en', 'like', '%' . request()->search . '%');
        })->when(request()->country, function ($q) {
            return $q->where('country_id', request()->country);
        })->when(request()->city, function ($q) {
            return $q->where('city_id', request()->city);
        })->when(request()->area, function ($q) {
            return $q->where('area_id', request()->area);
        });
    }

    //Scopes
    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getAvailable()
    {
        return $this->available == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getReservation_availability()
    {
        return $this->reservation_availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getDelivery_availability()
    {
        return $this->delivery_availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getReservation_active()
    {
        return $this->reservation_active == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getDelivery_active()
    {
        return $this->delivery_active == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getLogoAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }
}
