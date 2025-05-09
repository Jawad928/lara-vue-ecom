<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /***
     *
     * Display all orders
     *
     */

    public function index()
    {
        $orders = Order::with(['products', 'user', 'coupon'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /****
     * Update order status
     */

    public function updateDeliveredAtDate(Order $order)
    {
        $order->update([
            'delivered_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully');
    }


    /***
     *
     * Delete order
     */

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully');
    }
}
