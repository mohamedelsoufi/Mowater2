<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficClearingOfficeRequest extends Model
{
    use HasFactory, HasFiles;

    protected $table = 'traffic_clearing_office_requests';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'service_id' => 'array'
    ];


    //relationship start
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(TrafficClearingOffice::class);
    }

    public function service()
    {
        return $this->belongsTo(TrafficClearingService::class,'traffic_clearing_service_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function car_class()
    {
        return $this->belongsTo(CarClass::class);
    }

    public function car_model()
    {
        return $this->belongsTo(CarModel::class);
    }

    //relationship end

    //scopes
    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? asset('uploads' . $default_image->path) : null;
    }

    public function setFirstNameAttribute($val)
    {
        $this->attributes['first_name'] = ucwords($val);
    }

    public function setLastNameAttribute($val)
    {
        $this->attributes['last_name'] = ucfirst($val);
    }

    public function setNickNameAttribute($val)
    {
        $this->attributes['nickname'] = ucfirst($val);
    }
}
