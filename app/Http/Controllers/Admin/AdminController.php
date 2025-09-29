<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'usersCount'    => User::count(),
            'productsCount' => Product::count(),
            'ordersCount'   => Order::count(),
            'latestOrders'  => Order::latest()->take(5)->get(),
        ]);
    }
}
