<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use App\Traits\Files\HasFiles;
use App\Traits\WorkTimes\HasWorkTimes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TechnicalInspectionCenterService extends Model
{
    use HasFactory, HasFiles, HasWorkTimes, HasAds;

    protected $table = 'technical_inspection_center_services';

    protected $fillable = ['id', 'technical_inspection_center_id', 'name_en', 'name_ar', 'description_en'
        , 'description_ar', 'price', 'discount', 'discount_type', 'number_of_views','active_number_of_views', 'available', 'active'];

    protected $appends = ['name', 'description', 'one_image', 'price_after_discount'];

    protected $hidden = ['name_ar', 'name_en', 'description_ar', 'description_en', 'created_at', 'updated_at'];

    public $timestamps = true;

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

    //relationship start
    public function inspectionCenter()
    {
        return $this->belongsTo(TechnicalInspectionCenter::class, 'technical_inspection_center_id');
    }

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }

    public function inspectionCenterRequests()
    {
        return $this->belongsToMany(RequestTechnicalInspection::class, 'inspection_center_request_services');
    }
    //relationship end

    //Scopes start
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
    }

    public function inspection_service_available_reservation($date, $id, $module, $service_model, $service_id)
    {
        try {

            $day = date("D", strtotime($date));

            $module = $module->with(['work_time', 'day_offs'])->find($id);

            $day_offs = $module->day_offs()->where('date', $date)->get();
            foreach ($day_offs as $day_off) {
                if ($day_off)
                    return $date . __('message.is_day_off');
            }

            $service = $service_model->with('work_time')->find($service_id);

            $service_work_time = $service->work_time;

            if (!$service_work_time)
                return __('message.no_result');
            if (date('Y-m-d', strtotime($date)) <= \Carbon\Carbon::yesterday()->format('Y-m-d')) {
                return __('message.requested_date') . $date . ' ' . __('message.date_is_old');
            }
            $find_day = array_search($day, $service_work_time->days);


            if ($find_day !== false) {

                $available_times = [];

                $from = date("H:i", strtotime($service_work_time->from));
                $to = date("H:i", strtotime($service_work_time->to));


                if (!in_array(date("h:i a", strtotime($from)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($from)));
                }

                $time_from = strtotime($from);

                $new_time = date("H:i", strtotime($service_work_time->duration . ' minutes', $time_from));
                if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($new_time)));
                }

                while ($new_time < $to) {
                    $time = strtotime($new_time);
                    $new_time = date("H:i", strtotime($service_work_time->duration . ' minutes', $time));
                    if ($new_time . ':00' >= $to) {
                        break;
                    }

                    if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                        array_push($available_times, date("h:i a", strtotime($new_time)));
                    }

                    $reservations = $service->inspectionCenterRequests;
                    if (!$reservations == null) {
                        foreach ($reservations as $key => $reservation) {
                            if ($reservation->pivot->technical_inspection_center_service_id == $service_id) {
                                if ($reservation->date == $date) {
                                    $formated = date("h:i a", strtotime($reservation->time));

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
            return  __('message.date_is_not_available');
        } catch (\Exception $e) {
            return array('error : ' . $e->getMessage());
        }
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

    public function getPriceAfterDiscountAttribute()
    {
        if ($this->discount != null) {
            $discount_type = $this->discount_type;
            $percentage_value = ((100 - $this->discount) / 100);
            if ($discount_type == 'percentage') {
                return $price_after_discount = $this->price * $percentage_value;
            } else {
                return $price_after_discount = $this->price - $this->discount;

            }
        }
        return 0;
    }


    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? $default_image->path : '';
    }
    // accessors & Mutator end
}

