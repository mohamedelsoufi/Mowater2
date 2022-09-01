<?php


namespace App\Traits\Reviews;

use Illuminate\Support\Facades\Auth;

trait HasReviews
{
    public function reviews()
    {
        return $this->morphMany('App\Models\Review', 'reviewable');
    }

    public function getRatingAttribute()
    {
        $total_ratings = 0;
        foreach ($this->reviews as $review) {
            $total_ratings += $review->rate;
        }
        $count_reviews = $this->reviews()->count();
        if ($count_reviews) {
            $avg_rating = $total_ratings / $count_reviews;
            return $avg_rating;
        }

        return 5;
    }

    public function getRatingCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getIsReviewedAttribute()
    {
        if(Auth::guard('api')->check())
        {
            $user = Auth::guard('api')->user();

            return $this->reviews()->where('user_id' , $user->id)->exists();
        }
        return false;

    }
}
