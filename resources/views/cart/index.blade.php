@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-3">Keranjang</h1>
@if($cart->items->isEmpty())
  <div>Keranjang kosong.</div>
@else
<table class="w-full border rounded">
  <thead class="bg-gray-50">
    <tr><th class="p-2 text-left">Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th><th></th></tr>
  </thead>
  <tbody>
  @foreach($cart->items as $i)
    <tr class="border-t">
      <td class="p-2"><a class="hover:underline" href="{{ route('products.show',$i->product) }}">{{ $i->product->name }}</a></td>
      <td class="text-center">Rp {{ number_format($i->product->price,0,',','.') }}</td>
      <td class="text-center">
        <form method="POST" action="{{ route('cart.update',$i) }}" class="inline-flex gap-2 items-center">
          @method('PATCH') @csrf
          <input type="number" name="qty" value="{{ $i->qty }}" min="1" class="border p-1 rounded w-20 text-center">
          <button class="border px-2 rounded">Perbarui</button>
        </form>
      </td>
      <td class="text-center">Rp {{ number_format($i->qty*$i->product->price,0,',','.') }}</td>
      <td class="text-center">
        <form method="POST" action="{{ route('cart.remove',$i) }}">@method('DELETE') @csrf
          <button class="border px-2 rounded">Hapus</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
<div class="mt-3">Total: <b>Rp {{ number_format($cart->total(),0,',','.') }}</b></div>
<a href="{{ route('checkout.show') }}" class="inline-block mt-3 border px-3 py-2 rounded">Checkout</a>
@endif
@endsection
