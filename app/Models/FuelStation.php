<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Contacts\HasContacts;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\Files\HasFile;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Phones\HasPhones;
use App\Traits\Reviews\HasReviews;
use App\Traits\Services\HasServices;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class FuelStation extends Model
{
    use HasFactory, HasWorkTimes,HasContacts, HasDayoffs, HasReviews, CanBeFavourites, HasAds,
        HasOrgUsers, HasPhones, HasServices,HasPaymentMethods;

    protected $table = 'fuel_stations';
    protected $guarded = [];
    public $timestamps = true;
    protected $hidden = ['name_en', 'name_ar', 'address_en', 'address_ar', 'created_at', 'updated_at'];
    protected $appends = ['name', 'address', 'rating', 'rating_count', 'is_reviewed', 'is_favorite','favorites_count'];

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function getAddressAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->address_ar;
        return $this->address_en;
    }
    // appends attributes end

    // relations start
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
    // relations end

    // Scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
    }

    public function scopeSelection($query)
    {
        return $query->select('id', 'name_en', 'name_ar', 'address_en', 'address_ar', 'fuel_types',
            'logo', 'country_id', 'city_id', 'area_id', 'latitude', 'longitude','number_of_views');
    }

    public function scopeSearch($query)
    {
        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%')
                ->orWhere('address_ar', 'like', '%' . request()->search . '%')
                ->orWhere('address_en', 'like', '%' . request()->search . '%');
        })->when(request()->country, function ($q) {
            return $q->where('country_id', request()->country);
        })->when(request()->city, function ($q) {
            return $q->where('city_id', request()->city);
        })->when(request()->area, function ($q) {
            return $q->where('area_id', request()->area);
        });
    }
    // Scopes end

    // accessors & Mutator start
    public function getFuelTypesAttribute($val)
    {
        return explode(",", $val);
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
    }

    public function getAvailable()
    {
        return $this->available == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getLogoAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }
    // accessors & Mutator end
}
