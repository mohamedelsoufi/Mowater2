<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class DiscountCard extends Model
{
    use HasFactory;
    protected $table = 'discount_cards';
    protected $fillable = ['id', 'title_en', 'title_ar', 'description_en', 'description_ar', 'price', 'year', 'image', 'status', 'active_number_of_views', 'number_of_views', 'active'];
    protected $hidden = ['title_en', 'title_ar', 'description_en', 'description_ar', 'created_at', 'updated_at'];
    public $timestamps = true;
    protected $appends = ['title', 'description'];

    // appends attributes start
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
    // appends attributes End


    // relationship start
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'discount_card_users', 'user_id', 'discount_card_id')->withPivot('id', 'barcode', 'vehicles', 'price')->withTimestamps();
    }

    public function agency()
    {
        return $this->morphedByMany(Agency::class, 'organizable');
    }

    public function car_showroom()
    {
        return $this->morphedByMany(CarShowroom::class, 'organizable');
    }

    public function wench()
    {
        return $this->morphedByMany(Wench::class, 'organizable');
    }

    public function garage()
    {
        return $this->morphedByMany(Garage::class, 'organizable');
    }

    public function special_number()
    {
        return $this->morphedByMany(SpecialNumber::class, 'organizable');
    }

    public function rental_office()
    {
        return $this->morphedByMany(RentalOffice::class, 'organizable');
    }

    public function scrap()
    {
        return $this->morphedByMany(Scrap::class, 'organizable');
    }

    public function spare_part()
    {
        return $this->morphedByMany(SparePart::class, 'organizable');
    }

    public function broker()
    {
        return $this->morphedByMany(Broker::class, 'organizable');
    }

    public function insurance_company()
    {
        return $this->morphedByMany(InsuranceCompany::class, 'organizable');
    }

    public function deliver_man()
    {
        return $this->morphedByMany(DeliveryMan::class, 'organizable');
    }

    public function driving_trainer()
    {
        return $this->morphedByMany(DrivingTrainer::class, 'organizable');
    }
    // relationship end

    // scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getImageAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }
    // scopes end

    // accessors & Mutator start
    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
    }

    public function getStatus()
    {
        if ($this->status == 'not_started')
            return __('words.not_started');
        if ($this->status == 'started')
            return __('words.started');
        if ($this->status == 'finished')
            return __('words.finished');

    }
    // accessors & Mutator end
}
