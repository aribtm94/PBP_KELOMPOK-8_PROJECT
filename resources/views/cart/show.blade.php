@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-3">Checkout</h1>
<form method="POST" action="{{ route('checkout.store') }}" class="grid md:grid-cols-2 gap-4">@csrf
  <div class="border rounded p-3">
    <h2 class="font-semibold">Alamat Pengiriman</h2>
    <input class="border p-2 rounded w-full mt-2" name="receiver_name" placeholder="Nama penerima" required>
    <textarea class="border p-2 rounded w-full mt-2" name="address_text" rows="4" placeholder="Alamat lengkap" required></textarea>
    <input class="border p-2 rounded w-full mt-2" name="phone" placeholder="No. telp (opsional)">
  </div>
  <div class="border rounded p-3">
    <h2 class="font-semibold">Ringkasan Pesanan</h2>
    <ul class="list-disc ml-5">
      @foreach($cart->items as $i)
        <li>{{ $i->product->name }} × {{ $i->qty }} = Rp {{ number_format($i->qty*$i->product->price,0,',','.') }}</li>
      @endforeach
    </ul>
    <div class="mt-2">Total: <b>Rp {{ number_format($cart->total(),0,',','.') }}</b></div>
    <button class="mt-4 border px-3 py-2 rounded w-full">Buat Pesanan</button>
  </div>
</form>
@endsection
