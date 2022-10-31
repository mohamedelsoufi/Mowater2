<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModelProduct extends Model
{
    use HasFactory;
    protected $table ='car_model_products';
    protected $fillable = ['id','car_model_id ','product_id','manufacturing_years'];

    public function getManufacturingYearsAttribute($val){
        return $this->attributes['manufacturing_years'] = explode(',', $val);
    }
}
