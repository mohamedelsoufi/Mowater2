<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryStorePurchase extends Model
{
    use HasFactory;

    protected $table = 'accessory_store_purchases';

    protected $fillable = ['id', 'accessories_store_id', 'user_id', 'first_name', 'last_name',
        'nickname', 'nationality', 'country_code', 'address', 'brand_id', 'car_model_id',
        'home_delivery', 'is_mawater_card', 'price'];

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = true;

    //relationship start
    public function accessoriesStore()
    {
        return $this->belongsTo(AccessoriesStore::class);
    }

    public function accessories()
    {
        return $this->belongsToMany(Accessory::class, 'accessory_store_purchase_accessories');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function car_model()
    {
        return $this->belongsTo(CarModel::class);
    }
    //relationship end

    // accessors & Mutator start
    public function setFirstNameAttribute($val)
    {
        $this->attributes['first_name'] = ucwords($val);
    }

    public function setLastNameAttribute($val)
    {
        $this->attributes['last_name'] = ucwords($val);
    }

    public function setNickNameAttribute($val)
    {
        $this->attributes['nickname'] = ucwords($val);
    }

    public function setNationalityAttribute($val)
    {
        $this->attributes['nationality'] = ucwords($val);
    }
    // accessors & Mutator end
}
