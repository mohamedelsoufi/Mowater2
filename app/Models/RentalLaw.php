<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class RentalLaw extends Model
{
    use HasFactory;
    protected $table = 'rental_laws';
    public $timestamps = true;
    protected $fillable = array('rental_office_id', 'title_en', 'title_ar');
    protected $hidden = ['created_at', 'updated_at', 'title_en', 'title_ar'];
    protected $appends = ['title'];

    //// appends attributes start //////
    public function getTitleAttribute()
    {
        if (App::getLocale() == 'ar')
            return $this->title_ar;
        return $this->title_en;
    }
    //// appends attributes end //////

    //relationship start
    public function rental_office()
    {
        return $this->belongsTo('App\Models\RentalOffice');
    }
    //relationship end

}
