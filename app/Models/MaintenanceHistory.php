<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class MaintenanceHistory extends Model
{
    use HasFactory;

    protected $table = 'maintenance_histories';

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = true;


    //relationship start
    public function vehicles()
    {
        return $this->belongsTo(Vehicle::class);
    }
    //relationship end

    public function getNameAttribute($val)
    {
        return $this->attributes['name'] = ucwords($val);
    }
}
