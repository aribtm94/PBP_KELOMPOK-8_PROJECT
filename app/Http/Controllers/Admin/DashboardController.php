<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:admin']);
    }

    public function index()
    {
        // Overall metrics
        $stats = [
            'users'    => User::count(),
            'products' => Product::count(),
            'orders'   => Order::count(),
            'revenue'  => (int) Order::whereIn('status', ['diproses', 'dikirim', 'selesai'])->sum('total'),
        ];

        // Order breakdown (use same status keys as OrderAdminController)
        $orderStats = [
            'new' => Order::where('status', 'baru')->count(),
            'processed' => Order::where('status', 'diproses')->count(),
            'sent' => Order::where('status', 'dikirim')->count(),
            'finished' => Order::where('status', 'selesai')->count(),
            'cancelled' => Order::where('status', 'batal')->count(),
        ];

        // Merge so the view can access both overall metrics and order breakdown
        $stats = array_merge($stats, $orderStats);

        // Latest orders with relations for display
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestOrders'));
    }
}
