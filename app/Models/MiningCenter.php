<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Contacts\HasContacts;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\OrganizationDiscountCards\HasOrganizationDiscountCard;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Phones\HasPhones;
use App\Traits\Reviews\HasReviews;
use App\Traits\Services\HasServices;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class MiningCenter extends Model
{
    use HasFactory, CanBeFavourites, HasContacts, HasReviews, HasWorkTimes, HasDayoffs, HasServices, HasAds,
        HasOrgUsers, HasPhones, HasOrganizationDiscountCard, HasPaymentMethods;

    protected $table = 'mining_centers';
    public $timestamps = true;
    protected $fillable = ['id', 'logo', 'name_en', 'name_ar', 'description_en', 'description_ar',
        'tax_number', 'address', 'city_id', 'number_of_views','active_number_of_views' , 'available', 'active'];
    protected $hidden = ['name_en', 'name_ar', 'description_en', 'description_ar', 'created_at', 'updated_at'];
    protected $appends = ['name', 'description', 'rating', 'rating_count', 'is_reviewed', 'is_favorite', 'favorites_count'];

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

    // appends attributes End

    // relations start
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function miningCenterService()
    {
        return $this->hasMany(MiningCenterService::class);
    }
    // relations end

    //Scopes start
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
        })->when(request()->city_id, function ($q) {
            return $q->where('city_id', request()->city_id);
        });
    }
    //Scopes end

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

    public function getLogoAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }
    // accessors & Mutator end
}
