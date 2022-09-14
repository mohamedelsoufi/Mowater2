<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class OrganizationUser extends Authenticatable
{
    use HasFactory, LaratrustUserTrait;

    protected $table = 'organization_users';
    public $timestamps = true;
    protected $fillable = ['id', 'organizable_type', 'organizable_id', 'user_name', 'email', 'password', 'remember_me', 'active'];
    protected $hidden = ['created_at', 'updated_at'];

    // relations start
    public function organizable()
    {
        return $this->morphTo();
    }

    // relations end

    // accessors & Mutator start
    public function setPasswordAttribute($val)
    {
        if (!empty($val)) {
            $this->attributes['password'] = bcrypt($val);
        }
    }

    public function getActive()
    {
        return $this->active == 1 ? __('words.active') : __('words.inactive');
    }
    // accessors & Mutator end
}
