<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Offer extends Model
{
    use HasFactory;
    protected $table = 'offers';
    protected $fillable = ['id', 'offerable_type', 'offerable_id', 'discount_card_id', 'discount_type', 'discount_value', 'number_of_uses_times', 'specific_number','notes'];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = true;

    //relationship start
    public function offerable()
    {
        return $this->morphTo();
    }

    public function discount_card()
    {
        return $this->belongsTo(DiscountCard::class,'discount_card_id');
    }
    //relationship end

}
