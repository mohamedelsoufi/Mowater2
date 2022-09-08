<?php

namespace App\Models;

use App\Traits\Branches\HasBranches;
use App\Traits\Categories\InCategories;
use App\Traits\Contacts\HasContacts;
use App\Traits\Ads\HasAds;
use App\Traits\Dayoffs\HasDayoffs;
use App\Traits\Favourites\CanBeFavourites;
use App\Traits\OrganizationDiscountCards\HasOrganizationDiscountCard;
use App\Traits\OrganizationUsers\HasOrgUsers;
use App\Traits\PaymentMethods\HasPaymentMethods;
use App\Traits\Products\HasProducts;
use App\Traits\Reviews\HasReviews;
use App\Traits\Services\HasServices;
use App\Traits\Vehicles\HasVehicles;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Traits\Phones\HasPhones;
use Illuminate\Support\Facades\DB;

class Agency extends Model
{
    use HasFactory, CanBeFavourites, HasContacts, HasReviews, HasWorkTimes, HasDayoffs, HasServices, HasAds,
        HasProducts, HasBranches, HasVehicles, HasOrgUsers, HasPhones, HasOrganizationDiscountCard,
        InCategories, HasPaymentMethods;
    protected $table = 'agencies';
    public $timestamps = true;
    protected $fillable = ['id', 'name_en', 'name_ar', 'description_en', 'description_ar', 'brand_id',
        'tax_number', 'logo', 'country_id', 'city_id', 'area_id', 'year_founded', 'active_number_of_views', 'number_of_views', 'reservation_availability', 'delivery_availability', 'reservation_active', 'delivery_active', 'active', 'available',];
    protected $hidden = ['name_en', 'name_ar', 'description_en', 'description_ar', 'created_at', 'updated_at'];
    protected $appends = ['name', 'description', 'rating', 'rating_count', 'is_reviewed', 'is_favorite', 'favorites_count', 'car_models'];

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

    public function getCarModelsAttribute()
    {
        return $this->getCarModels();
    }
    // appends attributes End

    // relationship start
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
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

    public function tests()
    {
        return $this->hasManyThrough(TestDrive::class, Vehicle::class, 'vehicable_id', 'vehicle_id');
    }

    public function reserve_vehicles()
    {
        return $this->hasManyThrough(ReserveVehicle::class, Vehicle::class, 'vehicable_id', 'vehicle_id');
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

    public function scopeSelection($query)
    {
        return $query->select('id', 'name_ar', 'name_en', 'description_en', 'description_ar', 'brand_id', 'tax_number',
            'logo', 'reservation_availability', 'delivery_availability', 'reservation_active', 'delivery_active',
            'country_id', 'city_id', 'area_id', 'year_founded', 'available', 'active_number_of_views', 'number_of_views');
    }

    public function scopeSearch($query)
    {

        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%')
                ->orWhere('description_ar', 'like', '%' . request()->search . '%')
                ->orWhere('description_en', 'like', '%' . request()->search . '%');
        })->when(request()->brand, function ($q) {
            return $q->where('brand_id', request()->brand);
        })->when(request()->country, function ($q) {
            return $q->where('country_id', request()->country);
        })->when(request()->city, function ($q) {
            return $q->where('city_id', request()->city);
        })->when(request()->area, function ($q) {
            return $q->where('area_id', request()->area);
        })->when(request()->model_name, function ($q) {
            return $q->wherehas('brand', function (Builder $query) {
                $query->whereHas('car_model', function (Builder $query) {
                    return $query->where('is_new', request()->is_new);
                });
            });
        })
            ->when(request()->vehicle_type, function ($q) {
                return $q->whereHas('vehicles', function ($q2) {
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
        return $this->reservation_active == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getDeliveryActive()
    {
        return $this->delivery_active == 1 ? __('words.available_prop') : __('words.not_available_prop');
    }

    public function getActiveNumberOfViews()
    {
        return $this->active_number_of_views == 1 ? __('words.active') : __('words.inactive');
    }

    public function getCarModels()
    {
        $agency = $this->find($this->id);
        $vehicles = $agency->vehicles()->where('active', 1)->get();
        $car_models = CarModel::whereIn('id', $vehicles->pluck('car_model_id'))->get();
//        $car_classes = [];
        foreach ($car_models as $car_model) {
            $car_model->min_price = $vehicles->where('car_model_id', $car_model->id)->min('price');

            $car_model->max_price = $vehicles->where('car_model_id', $car_model->id)->max('price');

            $car_model->image = $vehicles->first()->one_image;

            $manufacturing_years = $vehicles->whereIn('car_model_id', $car_model->id)->pluck('manufacturing_year')->toArray();
            $values = array_values(array_unique($manufacturing_years));

            foreach ($values as $key => $manufacturing_year) {
                $classes = CarClass::whereIn('id', $vehicles->where('car_model_id', $car_model->id)
                    ->where('manufacturing_year', $manufacturing_year)->where('active', 1)->pluck('car_class_id'))
                    ->get();
                foreach ($classes as $class) {
                    $vehicle = Vehicle::where('brand_id', $agency->brand_id)->where('car_model_id', $car_model->id)
                        ->where('car_class_id', $class->id)->where('manufacturing_year', $manufacturing_year)
                        ->where('active', 1)->first();

                    $file = $vehicle->files()->first();
                    $class->color_code = Color::where('id', $file->color_id)->first()->color_code;
                    $class->image = $vehicle->one_image;
                }
                $car_classes[$key] = [
                    'year' => $manufacturing_year,
                    'classes' => $classes
                ];
            }
            $car_model->manufacturing_years = $car_classes;

        }


        return $car_models;
    }

    public function getLogoAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }

    public function getRefNameAttribute()
    {
        return 'Agencies';
    }
    // accessors & Mutator end
}
