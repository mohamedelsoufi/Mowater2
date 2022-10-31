<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokerPackageFeature extends Model
{
    use HasFactory;

    protected $table = 'broker_package_features';

    protected $guarded = ['id','broker_package_id','feature_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = true;

    // relation start

    // relation end
}
