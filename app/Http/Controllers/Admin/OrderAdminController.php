<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller {
    public function __construct(){ $this->middleware(['auth','can:admin']); }

    public function index() {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order) {
        $order->load(['items.product','user']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $r, Order $order) {
        $data = $r->validate(['status'=>'required|in:baru,diproses,dikirim,selesai,batal']);
        $order->update(['status'=>$data['status']]);
        return back()->with('success','Status diperbarui.');
    }
}
