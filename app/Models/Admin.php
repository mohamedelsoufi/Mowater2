<?php

namespace App\Models;

use App\Traits\Vehicles\HasVehicles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class Admin extends Authenticatable
{
    use HasFactory, HasVehicles,LaratrustUserTrait;

    protected $table = 'admins';
    public $timestamps = true;
    protected $fillable = ['first_name','last_name', 'email', 'password','active','created_by'];
    protected $hidden = ['password', 'remember_token'];

    // accessors & Mutator start
    public function setPasswordAttribute($val){
        if (!empty($val)){
            $this->attributes['password'] = bcrypt($val);
        }
    }

    public function setFirstNameAttribute($val)
    {
        $this->attributes['first_name'] = ucwords($val);
    }

    public function setLastNameAttribute($val)
    {
        $this->attributes['last_name'] = ucwords($val);
    }
    // accessors & Mutator end

    //Scopes start
    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }
    //Scopes end
}
