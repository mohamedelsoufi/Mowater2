<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReserveVehicle extends Model
{
    use HasFactory, HasFiles;
    protected $table = 'reserve_vehicles';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    // relation start
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    //scopes
    public function getOneImageAttribute()
    {
        $default_image = $this->files()->first();
        return $default_image ? asset('uploads' . $default_image->path) : null ;
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
