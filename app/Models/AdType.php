<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class AdType extends Model
{
    use HasFactory;
    protected $table = 'ad_types';
    protected $fillable = ['name_ar', 'name_en', 'priority', 'price'];
    protected $appends = ['name'];
    public $timestamps = false;

    //// appends attributes start //////
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function ad()
    {
        return $this->belongsToMany(Ad::class);
    }
}
