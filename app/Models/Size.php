<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['name'];



    public function products()
    {
        return $this->belongsToMany(Product::class);
    }



    public function getRouteKeyName()
    {
        return 'id';
    }
}
