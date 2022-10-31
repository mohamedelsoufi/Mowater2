<?php

namespace App\Models;

use App\Traits\Ads\HasAds;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficClearingServiceUse extends Model
{
    use HasFactory, HasAds;

    protected $table = 'traffic_clearing_service_uses';

    protected $guarded = [];

    public $timestamps = true;

    protected $hidden = ['created_at', 'updated_at'];

    //relationship start
    public function traffic_office()
    {
        return $this->belongsTo(TrafficClearingOffice::class, 'traffic_clearing_office_id');
    }

    public function traffic_service()
    {
        return $this->belongsTo(TrafficClearingService::class, 'traffic_clearing_service_id');
    }

    public function offers()
    {
        return $this->morphMany(Offer::class, 'offerable');
    }
    //relationship end

}
