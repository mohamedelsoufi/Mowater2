<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InsuranceCompany;
use Illuminate\Support\Facades\App;

class Law extends Model
{
    use HasFactory;
    protected $table='insurance_company_laws';
    protected $fillable = array('law_en','law_ar', 'insurance_company_id');
    protected $appends=['law'];

    //appends//
    public function getLawAttribute()
    {
        if (App::getLocale() == 'ar') {
            return $this->law_ar;
        }
        return $this->law_en;
    }

    //end of appends

    //relations
    public function lawable()
    {
        return $this->morphTo();
    }
}
