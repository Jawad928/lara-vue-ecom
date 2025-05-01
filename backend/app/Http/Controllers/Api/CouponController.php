<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //
    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::whereName($request->name)->first();

        if ($coupon && $coupon->checkIfValid()) {
            return response()->json([

                'message' => 'Coupon applied successfully',
                'coupon' => $coupon
            ]);
        } else {
            return response()->json([

                "error" => 'invalid or expired coupon',

            ]);
        }
    }
}
