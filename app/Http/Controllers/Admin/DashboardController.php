<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Product, Order};

class DashboardController extends Controller
{
    public function __construct() { $this->middleware(['auth','can:admin']); }

    public function __invoke()
    {
        $stats = [
            'users'    => User::count(),
            'products' => Product::count(),
            'orders'   => Order::count(),
            'revenue'  => (int) Order::whereIn('status',['diproses','dikirim','selesai'])->sum('total'),
        ];
        $latestOrders = Order::latest()->take(5)->get();
        return view('admin.dashboard', compact('stats','latestOrders'));
    }
}
