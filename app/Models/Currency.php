<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';
    protected $fillable = ['id', 'name_en', 'name_ar', 'code', 'created_by'];
    protected $hidden = ['name_en', 'name_ar', 'created_at', 'updated_at'];
    public $timestamps = true;
    protected $appends = ['name'];

    // appends attributes start
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->name_ar;
        return $this->name_en;
    }
    // appends attributes end

    // relations start
    public function country()
    {
        return $this->hasOne(Country::class);
    }
    // relations end

    // scopes start
    public function scopeSelection($query)
    {
        return $query->select('id', 'name_en', 'name_ar', 'code');
    }

    public function scopeSearch($query)
    {
        $query->when(request()->search, function ($q) {
            return $q->where('name_ar', 'like', '%' . request()->search . '%')
                ->orWhere('name_en', 'like', '%' . request()->search . '%');
        })->when(request()->code, function ($q) {
            return $q->where('code', request()->code);
        })->when(request()->country_id, function ($q) {
            return $q->wherehas('country', function (Builder $query) {
                $query->where('id', request()->country_id);
            });
        });
    }
    // scopes end

    // accessors & Mutator start
    public function setNameEnAttribute($val)
    {
        $this->attributes['name_en'] = ucwords($val);
    }
    // accessors & Mutator end
}
