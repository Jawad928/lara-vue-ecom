<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['qty', 'total', 'delivered_at', 'user_id', 'coupon_id'];


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function coupen()
    {
        return $this->belongsTo(Coupon::class);
    }




    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }




    public function getDeliveredAtAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->diffForHumans();
        } else {
            return null;
        }
    }

    /**
     *local scope for today,yesterday,thismonth,and thisyear oders detail
     *
     */

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    public function scopeYesterday($query)
    {
        return $query->whereDate('created_at', Carbon::yesterday());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->month);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('created_at', Carbon::now()->year);
    }
}