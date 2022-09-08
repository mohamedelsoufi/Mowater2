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
use App\Traits\Reviews\HasReviews;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Traits\Phones\HasPhones;


class RentalOffice extends Model
{
    use HasFactory, CanBeFavourites, HasContacts, HasWorkTimes,HasBranches,
        HasDayoffs, HasPaymentMethods, HasReviews, HasAds, HasOrgUsers , HasPhones,HasOrganizationDiscountCard;

    protected $table = 'rental_offices';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['name_ar', 'name_en', 'description_ar', 'description_en', 'created_at', 'updated_at'];

    protected $appends = ['name', 'description', 'rating', 'rating_count', 'is_reviewed', 'is_favorite','favorites_count'];

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->name_ar;
        return $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->description_ar;
        return $this->description_en;
    }
    // appends attributes end

    // relationship start
    public function rental_laws()
    {
        return $this->hasMany('App\Models\RentalLaw');
    }

    public function rental_office_cars()
    {
        return $this->hasMany(RentalOfficeCar::class);
    }

    public function rental_reservations()
    {
        return $this->hasManyThrough(RentalReservation::class, RentalOfficeCar::class , 'rental_office_id' , 'rental_office_car_id');
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

    public function scopeReservationAvailability($query)
    {
        return $query->where('reservation_availability', 1);
    }

    public function scopeSelection($query)
    {
        return $query->select('id', 'name_en', 'name_ar', 'description_en', 'description_ar',
            'tax_number', 'logo', 'reservation_availability', 'delivery_availability', 'reservation_active',
            'delivery_active', 'country_id', 'city_id', 'area_id', 'year_founded','number_of_views','active_number_of_views');
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
        })->when(request()->vehicle_type, function ($q) {
            return $q->whereHas('rental_office_cars', function ($q2) {
                $q2->where('vehicle_type', request()->vehicle_type);
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

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
    }

    public function getReservationAvailability()
    {
        return $this->reservation_availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getDeliveryAvailability()
    {
        return $this->delivery_availability == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getReservationActive()
    {
        return $this->reservation_active == 1 ? __('words.inactive') : __('words.inactive');
    }

    public function getDeliveryActive()
    {
        return $this->delivery_active == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getLogoAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }
    // accessors & Mutator end
}
