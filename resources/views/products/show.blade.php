@extends('layouts.app')

@section('content')
<div class="grid md:grid-cols-2 gap-6">
  <div>@if($product->image_path)<img src="{{ asset('storage/'.$product->image_path) }}" class="w-full rounded">@endif</div>
  <div>
    <h1 class="text-2xl font-bold mb-2" style="color: #E0E0E0;">{{ $product->name }}</h1>
    <div style="color: #E0E0E0;">Kategori: {{ $product->category?->name ?? '-' }}</div>
    <div class="my-2" style="color: #E0E0E0;">Harga: <b>Rp {{ number_format($product->price,0,',','.') }}</b></div>
    <div style="color: #E0E0E0;">Stok: {{ $product->stock>0 ? $product->stock : 'habis' }}</div>
    @auth
    <form method="POST" action="{{ route('cart.add',$product) }}" class="mt-4 flex gap-2">@csrf
      <input name="qty" type="number" value="1" min="1" class="border p-1 rounded w-24">
      <button class="border px-3 rounded" style="color: #E0E0E0; border-color: #E0E0E0;">Tambah ke Keranjang</button>
    </form>
    @endauth
  </div>
</div>

<!-- Deskripsi Produk - Kolom Terpisah -->
<div class="mt-8">
  <h3 class="text-xl font-semibold mb-4" style="color: #E0E0E0;">Deskripsi Produk</h3>
  <div class="bg-[#A38560]/10 rounded-lg p-6 border border-[#A38560]/20">
    <p class="leading-relaxed" style="color: #E0E0E0;">{{ $product->description }}</p>
  </div>
</div>

@endsection
