@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Checkout</h1>

@if ($errors->any())
  <div class="bg-red-100 p-2 mb-3">
    @foreach($errors->all() as $e) <div style="color: #E0E0E0;">{{ $e }}</div> @endforeach
  </div>
@endif

<form method="POST" action="{{ route('checkout.store') }}" class="grid md:grid-cols-2 gap-4">@csrf
  <div class="border rounded p-3" style="border-color: #E0E0E0;">
    <h2 class="font-semibold" style="color: #E0E0E0;">Alamat Pengiriman</h2>
    <input class="border p-2 rounded w-full mt-2" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" name="receiver_name" placeholder="Nama penerima" required>
    <textarea class="border p-2 rounded w-full mt-2" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" name="address_text" rows="4" placeholder="Alamat lengkap" required></textarea>
    <input class="border p-2 rounded w-full mt-2" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" name="phone" placeholder="No. telp (opsional)">
  </div>
  <div class="border rounded p-3" style="border-color: #E0E0E0;">
    <h2 class="font-semibold" style="color: #E0E0E0;">Ringkasan Pesanan</h2>
    <ul class="list-disc ml-5">
      @foreach($cart->items as $i)
        <li style="color: #E0E0E0;">{{ $i->product->name }} × {{ $i->qty }} = Rp {{ number_format($i->qty * $i->product->price,0,',','.') }}</li>
      @endforeach
    </ul>
    <div class="mt-2" style="color: #E0E0E0;">Total: <b>Rp {{ number_format($cart->total(),0,',','.') }}</b></div>
    <button class="mt-4 border px-3 py-2 rounded w-full" style="color: #E0E0E0; border-color: #E0E0E0;">Buat Pesanan</button>
  </div>
</form>
@endsection
