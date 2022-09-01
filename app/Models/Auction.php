<?php

namespace App\Models;

use App\Traits\Vehicles\HasVehicles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Auction extends Model
{
    use HasFactory, HasVehicles;
    protected $table = 'auctions';

    protected $guarded = [];
    protected $dates = ['start_date', 'end_date'];
    protected $appends = ['max_bid', 'status', 'duration'];
    protected $hidden = ['start_date', 'end_date', 'created_at', 'updated_at'];

    public function start_date()
    {
        $start = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('d-m-Y g:i A');
        return $start;
    }

    public function end_date()
    {
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date)->format('d-m-Y g:i A');
        return $end;
    }

    public function now()
    {
        $now = Carbon::now()->format('d-m-Y g:i A');
        return $now;
    }

    //// appends attributes start //////
    public function getMaxBidAttribute()
    {
        return $this->bids()->max('bid_amount');
    }

    public function getDurationAttribute()
    {
        return $this->start_date && $this->end_date ? $this->start_date->diffInDays($this->end_date, false) : null;
    }

    public function getStatusAttribute()
    {

        if ($this->start_date() > $this->now()) {
            //not started
            return __('words.not_started');
        } elseif ($this->end_date() < $this->now()) {
            //ended
            return __('words.ended');

        } else {
            //currently
            return __('words.already_started');
        }
    }

    //relations
    public function insurance_company()
    {
        return $this->belongsTo(InsuranceCompany::class, 'insurance_company_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'auction_subscription', 'auction_id', 'user_id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class);
    }

//scopes
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


    public
    function scopeSelection($query)
    {
        return $query->select('id', 'serial_number', 'start_date', 'end_date', 'insurance_company_id');
    }

    public
    function scopeSearch($query)
    {
        $query->when(request()->start_date, function ($q) {
            return $q->whereDate('start_date', request()->start_date);
        })
            ->when(request()->end_date, function ($q) {
                return $q->whereDate('end_date', request()->end_date);
            })
            ->when(request()->has('current_auctions'), function ($q) {
                return $q->whereDate('start_date', '<=', Carbon::now()->format('Y-m-d H:i:s'))
                    ->whereDate('end_date', '>=', Carbon::now()->format('Y-m-d H:i:s'));
            })
            ->when(request()->has('new_auctions'), function ($q) {
                return $q->where('start_date', '>', Carbon::now()->format('Y-m-d H:i:s'));
            })
            ->when(request()->has('finished_auctions'), function ($q) {
                return $q->where('end_date', '<', Carbon::now()->format('Y-m-d H:i:s'));
            });
    }

}
