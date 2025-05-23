<?php

namespace App\Http\Controllers\Api;


use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class OrderController extends Controller
{
    /**
     * Store User's order
     */

    public function storeUserOrder(Request $request)
    {

        foreach ($request->cartItems as $item) {
            $order =   Order::create([
                'qty' => $item['qty'],
                'user_id' => $request->user()->id,
                'coupon_id' => $item['coupon_id'],
                'total' => $this->calculateEachOrderTotal($item['price'], $item['qty'], $item['coupon_id']),
            ]);
            $order->products()->attach($item['product_id']);
        }
        return response()->json([
            'user' => UserResource::make($request->user()),

        ]);
    }



    /**Calculate Each Order Total */

    public function calculateEachOrderTotal($price, $qty, $coupon_id)
    {
        $discount = 0;
        $total = $price * $qty;
        $coupon = Coupon::find($coupon_id);
        if ($coupon && $coupon->checkIfValid()) {
            $discount = $total * ($coupon->discount / 100);
        }
        return $total - $discount;
    }






    /**
     * pay order
     */

    public function payOrderByStripe(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a Stripe payment intent
        try {
            $checkout_session = Session::create([
                'line_items' => [[

                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'vue-T-shirt Store',
                        ],
                        'unit_amount' => $this->calculateTotalToPay($request->cartItems),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $request->success_url,
            ]);
            //return the link to stripe checkout page
            return response()->json([
                'url' => $checkout_session->url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }


    /***
     * Calculate Total to Pay
     */
    public function calculateTotalToPay($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $this->calculateEachOrderTotal($item['qty'], $item['price'], $item['coupon_id']);
        }
        return $total * 100;
    }
}
