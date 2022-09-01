<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCardOrganization extends Model
{
    use HasFactory;
    protected $table='discount_card_organizations';
    protected $fillable = ['id','discount_card_id','organizable_type','organizable_id','active'];
    protected $hidden = ['created_at','updated_at'];
    public $timestamps = true;

}
