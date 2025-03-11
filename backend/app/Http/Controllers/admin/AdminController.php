<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthAdminRequest;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * fetch today yesterday  this month and this years orders
     *  ** */

    public function index()
    {
        $todayOrders = Order::today()->get();
        $yesterdayOrders = Order::yesterday()->get();
        $monthOrders = Order::thismonth()->get();
        $yearOrders = Order::thisyear()->get();
        return view('admin.dashboard')->with([
            'todayOrders' => $todayOrders,
            'yesterdayOrders' => $yesterdayOrders,
            'monthOrders' => $monthOrders,
            'yearOrders' => $yearOrders,

        ]);
    }


    /**
     * display the login form
     */
    public function login()
    {
        if (!auth()->guard('admin')->check()) {
            return view('login');
        }
        return redirect()->route('admin.index');
    }

    /**
     * login Admin
     */
    public function auth(AuthAdminRequest $request)
    {


        if (auth()->guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();
            return redirect()->route('admin.index');
        } else {
            return redirect()->route('admin.login')->with([
                'error' => "These Credentials Do Not Match Any Of Our Records."
            ]);
        }
    }
    /**
     * Logout Admin
     */

    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
