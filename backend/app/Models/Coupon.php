<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['name', 'discount', 'valid_until'];

    /**
     * Mutator for Convert the Coupen name to uppercase
     */

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::upper($value);
    }
    /**
     *check if coupen is not expired
     */

    public function checkIfValid()
    {
        if ($this->valid_until > Carbon::now()) {
            return true;
        } else {
            return false;
        }
    }
}