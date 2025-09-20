<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    public function show()
    {
        $cart = auth()->user()->cart()->with('items.product')->firstOrFail();
        abort_if($cart->items->isEmpty(), 400, 'Keranjang kosong');
        return view('checkout.show', compact('cart'));
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

        $order = null;

        DB::transaction(function () use ($user, $cart, $data, &$order) {
            $total = 0;
            foreach ($cart->items as $i) {
                if ($i->qty > $i->product->stock) {
                    throw new \RuntimeException('Stok tidak cukup');
                }
                $total += $i->qty * $i->product->price;
            }

            $order = Order::create($data + [
                'user_id' => $user->id,
                'total'   => $total,
                'status'  => 'baru',
            ]);

            foreach ($cart->items as $i) {
                OrderItem::create([
                    'order_id'  => $order->id,
                    'product_id'=> $i->product_id,
                    'price'     => $i->product->price,
                    'qty'       => $i->qty,
                    'subtotal'  => $i->qty * $i->product->price,
                ]);
                $i->product->decrement('stock', $i->qty);
            }

            $cart->items()->delete();
        });

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan dibuat.');
    }
}
