<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscoutnCardUserUse extends Model
{
    use HasFactory;
    protected $table = 'discoutn_card_user_uses';
    protected $fillable = ['id', 'user_id','barcode', 'offer_id', 'original_number_of_uses', 'consumption_number', '', ''];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = true;


}
