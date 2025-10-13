<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    public function show(Request $request)
    {
        // Check if user just completed an order and is trying to go back
        if (session('order_completed')) {
            $orderId = session('completed_order_id');
            session()->forget(['order_completed', 'completed_order_id']);
            return redirect()->route('orders.show', $orderId)
                ->with('info', 'Pesanan sudah selesai. Tidak bisa kembali ke checkout.');
        }
        
        $cart = auth()->user()->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/')->with('error', 'Keranjang kosong');
        }
        
        // Calculate subtotal
        $subtotal = $cart->items->sum(function ($item) {
            return $item->qty * $item->product->price;
        });
        
        return view('checkout.show', compact('cart', 'subtotal'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'receiver_name' => 'required|string|max:100',
            'address_text'  => 'required|string|max:500',
            'phone'         => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $cart = $user->cart()->with('items.product')->firstOrFail();
        if ($cart->items->isEmpty()) return back()->with('error', 'Keranjang kosong');

        // Get voucher data from session if not in form data (with safe array access)
        $order = null;

        DB::transaction(function () use ($user, $cart, $data, &$order) {
            $subtotal = 0;
            foreach ($cart->items as $i) {
                if ($i->qty > $i->product->stock) {
                    throw new \RuntimeException('Stok tidak cukup');
                }
                $subtotal += $i->qty * $i->product->price;
            }

            $finalTotal = $subtotal;

            $order = Order::create($data + [
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'total'   => $finalTotal,
                'status'  => 'baru',
            ]);

            foreach ($cart->items as $i) {
                OrderItem::create([
                    'order_id'  => $order->id,
                    'product_id'=> $i->product_id,
                    'price'     => $i->product->price,
                    'qty'       => $i->qty,
                    'subtotal'  => $i->qty * $i->product->price,
                    'size'      => $i->size,
                ]);
                $i->product->decrement('stock', $i->qty);
            }

            $cart->items()->delete();
        });

        // Clear checkout-related session data after successful order
        session()->forget(['checkout_data', 'cart_total']);
        
        // Mark that order has been completed to prevent back navigation
        session(['order_completed' => true, 'completed_order_id' => $order->id]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat!')
            ->with('prevent_back', true);
    }
}
