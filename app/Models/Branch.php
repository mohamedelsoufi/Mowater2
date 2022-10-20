<?php

namespace App\Models;

use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Phones\HasPhones;
use App\Traits\Products\HasProducts;
use App\Traits\Reservations\CanBeReserved;
use App\Traits\Services\HasServices;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Contacts\HasContacts;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\Reviews\HasReviews;
use App\Traits\WorkTimes\HasWorkTimes;
use App\Traits\Dayoffs\HasDayoffs;
use App;

class Branch extends Model
{
    use CanBeFavourites, HasContacts, HasReviews, HasWorkTimes, HasDayoffs, HasOrgUsers
        , CanBeReserved,HasPaymentMethods,HasPhones;

    protected $table = 'branches';
    public $timestamps = true;
    protected $fillable = ['id', 'branchable_type', 'branchable_id', 'name_en', 'name_ar', 'country_id',
        'city_id', 'area_id', 'address_en', 'address_ar', 'category_id', 'longitude', 'latitude',
        'reservation_active', 'reservation_availability', 'delivery_availability', 'available',
        'number_of_views', 'active_number_of_views', 'created_by',];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['name', 'address','favorites_count'];


    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function getAddressAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->address_ar;
        }
        return $this->address_en;
    }

    //relationship start
    public function roles(){
        return $this->morphMany(Role::class,'rolable');
    }

    public function branchable()
    {
        return $this->morphTo();
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function available_vehicles()
    {
        return $this->morphedByMany('App\Models\Vehicle', 'usable', 'branch_use');
    }

    public function available_features()
    {
        return $this->morphedByMany(Feature::class, 'usable', 'branch_use');
    }

    public function tests()
    {
        return $this->hasMany('App\Models\TestDrive');
    }

    public function available_products()
    {
        return $this->morphedByMany('App\Models\Product', 'usable', 'branch_use');
    }

    public function available_services()
    {
        return $this->morphedByMany('App\Models\Service', 'usable', 'branch_use');
    }

    public function available_rental_cars()
    {
        return $this->morphedByMany(RentalOfficeCar::class, 'usable', 'branch_use');
    }

    public function reserve_vehicles()
    {
        return $this->hasMany('App\Models\ReserveVehicle');
    }

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }

    public function trafficClearingOfficeRequests()
    {
        return $this->hasMany(TrafficClearingOffice::class);
    }

    public function insuranceReservations()
    {
        return $this->hasMany(ReserveInsuranceCompanyService::class);
    }

    public function brokerReservations()
    {
        return $this->hasMany(BrokerReservation::class);
    }


    // Scopes start
    public function scopeSearch($query)
    {
        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%')
                ->orWhere('address_ar', 'like', '%' . request()->search . '%')
                ->orWhere('address_en', 'like', '%' . request()->search . '%');
        })->when(request()->city, function ($q) {
            return $q->where('city_id', request()->city);
        })->when(request()->area, function ($q) {
            return $q->where('area_id', request()->area);
        })->when(request()->category, function ($q) {
            return $q->where('category_id', request()->category);
        });

    }
    // Scopes end

    // accessors & Mutator start
    public function getAvailable()
    {
        return $this->available == 1 ? __('words.available_prop') : __('words.not_available_prop');
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
        return $this->reservation_active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getDeliveryActive()
    {
        return $this->delivery_active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
    }
    // accessors & Mutator end

}
