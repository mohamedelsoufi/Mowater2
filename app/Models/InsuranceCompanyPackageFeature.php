<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceCompanyPackageFeature extends Model
{
    use HasFactory;

    protected $table = 'insurance_company_package_features';

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = true;

    // relation start

    // relation end
}
