@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Keranjang</h1>
@if($cart->items->isEmpty())
  <div style="color: #E0E0E0;">Keranjang kosong.</div>
@else
<table class="w-full border rounded" style="border-color: #E0E0E0;">
  <thead class="bg-[#A38560]">
    <tr><th class="p-2 text-left" style="color: #E0E0E0;">Produk</th><th style="color: #E0E0E0;">Harga</th><th style="color: #E0E0E0;">Qty</th><th style="color: #E0E0E0;">Subtotal</th><th></th></tr>
  </thead>
  <tbody>
  @foreach($cart->items as $i)
    <tr class="border-t" style="border-color: #E0E0E0;">
      <td class="p-2"><a class="hover:underline" style="color: #E0E0E0;" href="{{ route('products.show',$i->product) }}">{{ $i->product->name }}</a></td>
      <td class="text-center" style="color: #E0E0E0;">Rp {{ number_format($i->product->price,0,',','.') }}</td>
      <td class="text-center">
        <form method="POST" action="{{ route('cart.update',$i) }}" class="inline-flex gap-2 items-center">
          @method('PATCH') @csrf
          <input type="number" name="qty" value="{{ $i->qty }}" min="1" class="border p-1 rounded w-20 text-center" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;">
          <button class="border px-2 rounded" style="color: #E0E0E0; border-color: #E0E0E0;">Perbarui</button>
        </form>
      </td>
      <td class="text-center" style="color: #E0E0E0;">Rp {{ number_format($i->qty*$i->product->price,0,',','.') }}</td>
      <td class="text-center">
        <form method="POST" action="{{ route('cart.remove',$i) }}">@method('DELETE') @csrf
          <button class="border px-2 rounded" style="color: #E0E0E0; border-color: #E0E0E0;">Hapus</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
<div class="mt-3" style="color: #E0E0E0;">Total: <b>Rp {{ number_format($cart->total(),0,',','.') }}</b></div>
<a href="{{ route('checkout.show') }}" class="inline-block mt-3 border px-3 py-2 rounded" style="color: #E0E0E0; border-color: #E0E0E0;">Checkout</a>
@endif
@endsection
