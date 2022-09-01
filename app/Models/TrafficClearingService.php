<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TrafficClearingService extends Model
{
    use HasFactory, HasAds;

    protected $table = 'traffic_clearing_services';

    protected $guarded = [];

    public $timestamps = true;

    protected $hidden = ['name_en', 'name_ar', 'created_at', 'updated_at'];

    protected $appends = ['name'];

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }
    // appends attributes end

    //relationship start
    public function offices()
    {
        return $this->belongsToMany(TrafficClearingOffice::class, 'traffic_clearing_service_uses')->withPivot('fees', 'price');
    }
    //relationship end
}
