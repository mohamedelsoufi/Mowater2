<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Files\HasFiles;
use App\Traits\Reservations\CanBeReserved;
use App\Traits\Verifications\HasVerfications;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\App;
use App\Models\RequestProduct;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory, HasVerfications, CanBeReserved, HasFiles, HasAds;
    protected $table = 'products';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['name_en', 'name_ar', 'description_en', 'description_ar', 'created_at', 'updated_at'];
    protected $appends = ['name', 'description', 'one_image', 'price_after_discount'];

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

    //relations start
    public function productable()
    {
        return $this->morphTo();
    }

    public function branches()
    {
        return $this->morphToMany('App\Models\Branch', 'usable');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function car_model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function car_class()
    {
        return $this->belongsTo(CarClass::class);
    }

    public function car_models()
    {
        return $this->belongsToMany(CarModel::class, 'car_model_products')->withPivot('manufacturing_years');
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'product_reservation');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }
    //relations end

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
        return $query->select('id', 'productable_type', 'productable_id', 'name_en', 'name_ar', 'description_en', 'description_ar',
            'brand_id','car_model_id','car_class_id','manufacturing_year',
            'discount', 'discount_type', 'discount_availability', 'active', 'available', 'price', 'status',
            'type', 'is_new', 'category_id', 'sub_category_id', 'number_of_views','active_number_of_views');
    }

    public function scopeSearch($query)
    {
        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%')
                ->orWhere('description_ar', 'like', '%' . request()->search . '%')
                ->orWhere('description_en', 'like', '%' . request()->search . '%');
            })->when(request()->brand_id, function ($q) {
                return $q->where('brand_id', request()->brand_id);
            })->when(request()->car_model_id, function ($q) {
                return $q->where('car_model_id', request()->car_model_id);
            })->when(request()->car_class_id, function ($q) {
                return $q->where('car_class_id', request()->car_class_id);
            })->when(request()->manufacturing_year, function ($q) {
                return $q->where('manufacturing_year', request()->manufacturing_year);
            })->when(request()->engine_size, function ($q) {
                return $q->where('engine_size', request()->engine_size);
            })->when(request()->category, function ($q) {
                return $q->where('category_id', request()->category);
            })->when(request()->sub_category, function ($q) {
            return $q->where('sub_category_id', request()->sub_category);
        })->where(function ($q) {
            if (request()->filled('is_new')) {
                $q->where('is_new', request()->is_new);
            }
        });
    }
    //Scopes end

    // accessors & Mutator start
    public function get_offer($discount_card_id)
    {
        return $this->offers()->where('offers.discount_card_id', $discount_card_id)->first();
    }

    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? $default_image->path : null;
        //return $default_image ? asset('uploads/' . $default_image->path) : null;
    }

    public function getIsNew()
    {
        return $this->is_new == 1 ? __('words.new') : __('words.used');
    }

    public function getAvailability()
    {
        return $this->available == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
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
    // accessors & Mutator end
}
