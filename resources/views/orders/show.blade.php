@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-3">Detail Pesanan #{{ $order->id }}</h1>
<div class="grid md:grid-cols-2 gap-4">
  <div class="border rounded p-3">
    <div><b>Tanggal:</b> {{ $order->created_at->format('Y-m-d H:i') }}</div>
    <div><b>Status:</b> {{ $order->status }}</div>
    <div class="mt-2"><b>Penerima:</b> {{ $order->receiver_name }}</div>
    <div><b>Alamat:</b> {{ $order->address_text }}</div>
    <div><b>Telp:</b> {{ $order->phone ?? '-' }}</div>
  </div>
  <div class="border rounded p-3">
    <h2 class="font-semibold mb-2">Item</h2>
    <ul class="list-disc ml-5">
      @foreach($order->items as $i)
        <li>{{ $i->product->name }} × {{ $i->qty }} (Rp {{ number_format($i->price,0,',','.') }}) = Rp {{ number_format($i->subtotal,0,',','.') }}</li>
      @endforeach
    </ul>
    <div class="mt-2">Total akhir: <b>Rp {{ number_format($order->total,0,',','.') }}</b></div>
  </div>
</div>
@endsection
