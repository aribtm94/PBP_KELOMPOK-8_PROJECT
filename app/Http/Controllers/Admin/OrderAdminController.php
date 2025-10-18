<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->get();

        $stats = [
            'new' => Order::where('status', 'baru')->count(),
            'processed' => Order::where('status', 'diproses')->count(),
            'sent' => Order::where('status', 'dikirim')->count(),
            'finished' => Order::where('status', 'selesai')->count(),
            'cancelled' => Order::where('status', 'batal')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|string']);
        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
