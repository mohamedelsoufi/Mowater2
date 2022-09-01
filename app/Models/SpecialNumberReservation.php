<?php

namespace App\Models;

use App\Traits\Files\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialNumberReservation extends Model
{
    use HasFactory,HasFiles;
    protected $table = 'special_number_reservations';
    public $timestamps = true;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    //relationship start
    public function special_number()
    {
        return $this->belongsTo('App\Models\SpecialNumber');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relationship end
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
