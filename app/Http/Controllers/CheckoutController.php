<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            'payment_method' => 'required|string|in:qris,cod,transfer',
            'delivery_method' => 'nullable|string|in:same-day,express,regular',
            'delivery_fee' => 'nullable|numeric|min:0',
        ]);

        $user = auth()->user();
        $cart = $user->cart()->with('items.product')->firstOrFail();

        if ($cart->items->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        $order = null;

        DB::transaction(function () use ($user, $cart, $data, &$order) {
            $total = 0;

            foreach ($cart->items as $i) {
                if ($i->qty > $i->product->stock) {
                    throw new \RuntimeException("Stok produk '{$i->product->name}' tidak cukup. Stok tersedia: {$i->product->stock}, diminta: {$i->qty}");
                }

                $total += $i->qty * $i->product->price;
            }

            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => 'ORD' . strtoupper(uniqid()),
                'receiver_name'    => $data['receiver_name'],
                'receiver_address' => $data['address_text'],
                'receiver_phone'   => $data['phone'] ?? '-',
                'payment_method'   => $data['payment_method'],
                'status'           => 'baru',
                'total'            => $total,
            ]);

            foreach ($cart->items as $i) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $i->product_id,
                    'price'      => $i->product->price,
                    'qty'        => $i->qty,
                    'subtotal'   => $i->qty * $i->product->price,
                    'size'       => $i->size,
                ]);

                // Validasi stock sekali lagi sebelum decrement
                $product = $i->product->fresh(); // Ambil data terbaru
                if ($product->stock >= $i->qty) {
                    $product->decrement('stock', $i->qty);
                } else {
                    throw new \RuntimeException("Stok produk '{$product->name}' tidak mencukupi saat checkout");
                }
            }

            $cart->items()->delete();
        });

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}
