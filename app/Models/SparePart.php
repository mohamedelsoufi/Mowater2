<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Contacts\HasContacts;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\OrganizationDiscountCards\HasOrganizationDiscountCard;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Products\HasProducts;
use App\Traits\Reservations\CanBeReserved;
use App\Traits\Reviews\HasReviews;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
//use App\Models\OrderPiece;
use App\Traits\Phones\HasPhones;
use App\Traits\products_requests\HasProductsRequests;

class SparePart extends Model
{
    use HasFactory, HasOrgUsers, HasProducts, CanBeFavourites, HasProductsRequests, CanBeReserved,
        HasContacts, HasReviews, HasWorkTimes, HasDayoffs, HasAds, HasPhones, HasOrganizationDiscountCard,HasPaymentMethods;
    protected $fillable = array('name_en', 'name_ar', 'description_en', 'description_ar',
        'logo', 'active', 'available', 'reservation_availability', 'delivery_availability', 'reservation_active',
        'delivery_active', 'country_id', 'city_id', 'area_id', 'year_founded','number_of_views', 'created_at', 'updated_at');
    protected $hidden = ['name_en', 'name_ar', 'description_en', 'description_ar', 'created_at', 'updated_at'];
    protected $appends = ['name', 'description', 'rating', 'rating_count', 'is_reviewed', 'is_favorite','favorites_count'];
    protected $table = 'spare_parts';

    //// appends attributes start //////
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


    //relationships//
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
    //end//

    //Scopes
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
        return $query->select('id', 'name_ar', 'name_en', 'description_en', 'description_ar',
            'logo', 'reservation_availability', 'delivery_availability', 'reservation_active', 'delivery_active',
            'country_id', 'city_id', 'area_id', 'year_founded','number_of_views');
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
        })->when(request()->category_id, function ($q) {
            return $q->whereHas('products', function (Builder $q2) {
                $q2->where('category_id', request()->category_id);
            });
        })->when(request()->sub_category_id, function ($q) {
            return $q->whereHas('products', function (Builder $q2) {
                $q2->where('sub_category_id', request()->sub_category_id);
            });
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
