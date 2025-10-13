<?php

namespace App\Http\Controllers;

use App\Models\{Cart, CartItem, Product};
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function userCart(): Cart
    {
        return auth()->user()->cart ?? Cart::create(['user_id' => auth()->id()]);
    }

    public function index()
    {
        $cart = $this->userCart()->load('items.product');
        return view('cart.index', compact('cart'));
    }

    public function add(Request $r, Product $product)
    {
        $data = $r->validate([
            'qty' => 'required|integer|min:1',
            'size' => 'required|string'
        ]);

        $cart = $this->userCart();
        
        // Find existing item with same product and size
        $item = $cart->items()->where([
            'product_id' => $product->id,
            'size' => $data['size']
        ])->first();

        if ($item) {
            // Update existing item quantity
            $item->qty = $item->qty + $data['qty'];
        } else {
            // Create new item
            $item = new CartItem([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'size' => $data['size'],
                'qty' => $data['qty']
            ]);
        }

        if ($item->qty > $product->stock) {
            return back()->with('error', 'Qty melebihi stok.');
        }

        $item->save();
        return back()->with('success', 'Ditambahkan ke keranjang.');
    }

    public function updateQty(Request $r, CartItem $item)
    {
        abort_unless($item->cart->user_id === auth()->id(), 403);

        $data = $r->validate(['qty' => 'required|integer|min:1']);
        if ($data['qty'] > $item->product->stock) {
            return back()->with('error', 'Qty melebihi stok.');
        }

        $item->update(['qty' => $data['qty']]);
        return back()->with('success', 'Jumlah diperbarui.');
    }

    public function remove(CartItem $item)
    {
        abort_unless($item->cart->user_id === auth()->id(), 403);
        $item->delete();
        return back()->with('success', 'Item dihapus.');
    }


}
