<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationMessage extends Model
{
    use HasFactory;

    protected $table = 'notification_messages';

    protected $guarded = [];

    public $timestamps = true;

    // relations start
    public function notifiable(){
        return $this->morphTo();
    }
    // relations end
}
