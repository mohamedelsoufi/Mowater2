<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Ad extends Model
{
    use HasFactory, HasFiles;
    protected $fillable = array('organizationable_type', 'organizationable_id', 'title_en', 'title_ar', 'description_en',
        'description_ar', 'created_at', 'updated_at', 'ad_type_id', 'price', 'negotiable', 'country_id',
        'city_id', 'area_id', 'start_date', 'end_date', 'number_of_views','active_number_of_views');
    protected $appends = ['title', 'description'];
    protected $hidden = ['title_en', 'title_ar', 'description_en',
        'description_ar', 'created_at', 'updated_at'];

    //appends attributes start
    public function getTitleAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->title_ar;
        }
        return $this->title_en;
    }

    public function getDescriptionAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->description_ar;
        }
        return $this->description_en;
    }
    //appends attributes End

    //relations start
    public function organizationable()
    {
        return $this->morphTo();
    }

    public function module()
    {
        return $this->morphTo();
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

    public function adType()
    {
        return $this->belongsTo(AdType::class);
    }
    //relations end

    //Scopes start
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
        return $query->select('id', 'organizationable_type', 'organizationable_id', 'title_en', 'title_ar',
            'description_ar', 'description_en', 'ad_type_id',
            'country_id', 'city_id', 'area_id', 'number_of_views','active_number_of_views');
    }

    public function scopeSearch($query)
    {
        $query->when(request()->search, function ($q) {
            return $q->where('title_en', 'like', '%' . request()->search . '%')
                ->orWhere('title_ar', 'like', '%' . request()->search . '%')
                ->orWhere('description_en', 'like', '%' . request()->search . '%')
                ->orWhere('description_ar', 'like', '%' . request()->search . '%');;
        })->when(request()->country, function ($q) {
            return $q->where('country_id', request()->country);
        })->when(request()->city, function ($q) {
            return $q->where('city_id', request()->city);
        })->when(request()->area, function ($q) {
            return $q->where('area_id', request()->area);
        })->when(request()->ref_name, function ($q) {
            return $q->where('organizationable_type', 'App\\Models\\' . request()->ref_name);
        });

    }
    // Scopes end

    // accessors & Mutator start
    public function getAvailability()
    {
        return $this->availability == 1 ? __('words.not_available_prop') : __('words.available_prop');
    }

    public function getStatus()
    {
        return $this->status == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getNegotiable()
    {
        return $this->negotiable == 1 ? __('words.accepted') : __('words.not_accepted');
    }

    public function getImageAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }

//    public function getStartDateAttribute(){
//        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('d-m-Y g:i A');
//    }

    public function getLinkAttribute($val)
    {
        if ($this->module_type == 'App\\Models\\Vehicle')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-vehicle?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\Service')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-service?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\Product')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-product?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\Accessory')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-accessory?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\CarWashService')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-car-wash-service?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\InsuranceCompanyPackage')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-insurance-package?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\BrokerPackage')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-broker-package?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\MiningCenterService')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-mining-center?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\RentalOfficeCar')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-rental-office?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\SpecialNumber')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-special_number?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\TechnicalInspectionCenterService')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-inspection-center-service?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\TireExchangeCenterService')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-tire-exchange-service?id=' . $this->module_id;

        if ($this->module_type == 'App\\Models\\TrafficClearingServiceUse')
            return $this->link = request()->getSchemeAndHttpHost() . '/api/show-traffic-clearing-office-service?id=' . $this->module_id;


        return $val;
    }

//    public function getOneImageAttribute()
//    {
//        $default_image = $this->files()->first();
//        return $default_image ? $default_image->path : null;
//        //return $default_image ? asset('uploads/' . $default_image->path) : null;
//    }
    // accessors & Mutator end
}

