<?php

namespace App\Models;

use App\Traits\Files\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Country extends Model
{
    use HasFactory, HasFile;
    protected $table = 'countries';
    public $timestamps = true;
    protected $fillable = array('id','name_en', 'name_ar','currency_id');
    protected $hidden = ['created_at', 'updated_at','name_en', 'name_ar'];

    protected $appends = ['name','image'];

    //// appends attributes start //////
    public function getNameAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->name_ar;
        return $this->name_en;
    }
    //// appends attributes end //////

    //relationship start
    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
    //relationship end

    //scopes
    public function scopeSelection($query){
        return $query->select('id','name_en', 'name_ar','currency_id');
    }

    public function getImageAttribute()
    {
        $default_image = $this->file()->first();
        return $default_image ? asset( $default_image->path) : null ;
    }

    public function setNameEnAttribute($val){
         $this->attributes['name_en'] = ucwords($val);
    }

}
