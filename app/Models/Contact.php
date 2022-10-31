<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'Contacts';
    public $timestamps = true;
    protected $fillable = array('contactable_type', 'contactable_id', 'facebook_link', 'whatsapp_number','country_code', 'phone', 'website', 'instagram_link');
    protected $hidden = ['created_at', 'updated_at'];

    //relationship start
    public function contactable()
    {
        return $this->morphTo();
    }
    //relationship end

}
