<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Branches\HasBranches;
use App\Traits\Contacts\HasContacts;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\OrganizationDiscountCards\HasOrganizationDiscountCard;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Phones\HasPhones;
use App\Traits\Reservations\CanBeReserved;
use App\Traits\Reviews\HasReviews;
use App\Traits\Services\HasServices;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TrafficClearingOffice extends Model
{
    use HasFactory,CanBeFavourites, HasContacts, HasReviews, HasWorkTimes, HasDayoffs, HasAds,
         HasBranches, HasOrgUsers, HasPhones, HasOrganizationDiscountCard,CanBeReserved,HasPaymentMethods;
    protected $table = 'traffic_clearing_offices';
    protected $guarded = [];
    public $timestamps = true;
    protected $hidden = ['name_en', 'name_ar', 'description_en', 'description_ar', 'created_at', 'updated_at'];
    protected $appends = ['name', 'description', 'rating', 'rating_count', 'is_reviewed', 'is_favorite','favorites_count'];

    // appends attributes start
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
    // appends attributes end

    // relationship start
    public function roles(){
        return $this->morphMany(Role::class,'rolable');
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

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }

    public function trafficServices()
    {
        return $this->belongsToMany(TrafficClearingService::class, 'traffic_clearing_service_uses')->withPivot('fees','price');
    }
    // relationship end

    // Scopes start
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
        })->when(request()->service, function ($q) {
            return $q->whereHas('services', function (Builder $query){
                $query->where('name_ar', 'like', '%' . request()->service . '%')
                    ->orWhere('name_en', 'like', '%' . request()->service . '%')
                    ->orWhere('description_ar', 'like', '%' . request()->service . '%')
                    ->orWhere('description_en', 'like', '%' . request()->service . '%');

            });
        });
    }
    // Scopes end

    // accessors & Mutator start
    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getAvailable()
    {
        return $this->available == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getReservationAvailability()
    {
        return $this->reservation_availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getReservationActive()
    {
        return $this->reservation_active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
    }

    public function getLogoAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }
    // accessors & Mutator end
}
