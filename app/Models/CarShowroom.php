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
use App\Traits\Vehicles\HasVehicles;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Traits\Phones\HasPhones;

class CarShowroom extends Model
{
    use HasFactory, CanBeFavourites, HasContacts, HasReviews, HasWorkTimes, HasDayoffs,
        HasVehicles, HasAds, HasOrgUsers, HasPhones, HasBranches, HasOrganizationDiscountCard, HasPaymentMethods;
    protected $table = 'car_showrooms';
    public $timestamps = true;
    protected $guarded = [];

    protected $hidden = ['name_ar', 'name_en', 'description_ar', 'description_en', 'created_at', 'updated_at'];

    protected $appends = ['name', 'description', 'rating', 'rating_count', 'is_reviewed', 'is_favorite', 'favorites_count'];

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

    public function reserve_vehicles()
    {
        return $this->hasManyThrough(ReserveVehicle::class,
            Vehicle::class, 'vehicable_id', 'vehicle_id')
            ->whereIn('vehicle_id',$this->vehicles()->pluck('id')->toArray());
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
        return $query->select('id', 'name_en', 'name_ar', 'description_en', 'description_ar',
            'tax_number', 'logo', 'reservation_availability', 'delivery_availability', 'reservation_active',
            'delivery_active', 'country_id', 'city_id', 'area_id', 'year_founded', 'active_number_of_views', 'number_of_views');
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

    public function available_reservation($id, $date, $vehicle_id)
    {
        try {

            $day = date("D", strtotime($date));

            $car_showroom = CarShowroom::with(['work_time', 'day_offs'])->find($id);


            $day_offs = $car_showroom->day_offs()->where('date', $date)->get();
            foreach ($day_offs as $day_off) {
                if ($day_off)
                    return [];
            }
            if (date('Y-m-d', strtotime($date)) <= \Carbon\Carbon::yesterday()->format('Y-m-d')) {
                return __('message.requested_date') . $date . ' ' . __('message.date_is_old');
            }
            $find_day = array_search($day, $car_showroom->work_time->days);


            if ($find_day !== false) {

                $module = $car_showroom->work_time;

                $available_times = [];

                $from = date("H:i", strtotime($module->from));
                $to = date("H:i", strtotime($module->to));


                if (!in_array(date("h:i a", strtotime($from)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($from)));
                }

                $time_from = strtotime($from);

                $new_time = date("H:i", strtotime($module->duration . ' minutes', $time_from));
                if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($new_time)));
                }

                while ($new_time < $to) {
                    $time = strtotime($new_time);
                    $new_time = date("H:i", strtotime($module->duration . ' minutes', $time));
                    if ($new_time . ':00' >= $to) {
                        break;
                    }

                    if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                        array_push($available_times, date("h:i a", strtotime($new_time)));
                    }


                    $tests = $car_showroom->tests;
                    if (!$tests == null) {
                        foreach ($tests as $key => $test) {
                            if ($test->vehicle_id == $vehicle_id) {
                                if ($test->date == $date) {
                                    $formated = date("h:i a", strtotime($test->time));

                                    if (($key = array_search($formated, $available_times)) !== false) {
                                        unset($available_times[$key]);
                                    }
                                }
                            }


                        }
                    }
                }

                return array_values($available_times);
            }
        } catch (\Exception $e) {
            return array('error : ' . $e->getMessage());
        }
    }

    public function getLogoAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }

    public function getBrands()
    {
        $car_showroom = $this->find($this->id);
        $vehicles = $car_showroom->vehicles()->where('active', 1)->get();
        $brands = Brand::whereIn('id', $vehicles->pluck('brand_id'))->get();
        foreach ($brands as $brand) {
            $brand->manufacturing_year = $vehicles->where('brand_id', $brand->id)->pluck('manufacturing_year');
            $brand->car_models = CarModel::whereIn('id', $vehicles->where('brand_id', $brand->id)->pluck('car_model_id'))->get();

            foreach ($brand->car_models as $car_model) {
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
                        $vehicle = $car_showroom->vehicles()->where('active', 1)
                            ->where('brand_id', $brand->id)->where('car_model_id', $car_model->id)
                            ->where('car_class_id', $class->id)->where('manufacturing_year', $manufacturing_year)->first();

                        $file = $vehicle->files()->first();
                        $class->color_code = Color::where('id', $file->color_id)->first()->color_code;
                        $class->image = $vehicle->one_image;


                        $car_classes[$key] = [
                            'year' => $manufacturing_year,
                            'classes' => $classes
                        ];
                    }

                }
                $car_model->manufacturing_years = $car_classes;
            }

            return $brands;
        }
    }

    // accessors & Mutator end
}
