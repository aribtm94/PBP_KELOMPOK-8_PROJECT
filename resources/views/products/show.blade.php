@extends('layouts.app')

@section('content')
<div class="grid md:grid-cols-2 gap-6">
  <div>@if($product->image_path)<img src="{{ asset('storage/'.$product->image_path) }}" class="w-full rounded">@endif</div>
  <div>
    <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
    <div>Kategori: {{ $product->category?->name ?? '-' }}</div>
    <div class="my-2">Harga: <b>Rp {{ number_format($product->price,0,',','.') }}</b></div>
    <div>Stok: {{ $product->stock>0 ? $product->stock : 'habis' }}</div>
    <p class="mt-2">{{ $product->description }}</p>
    @auth
    <form method="POST" action="{{ route('cart.add',$product) }}" class="mt-4 flex gap-2">@csrf
      <input name="qty" type="number" value="1" min="1" class="border p-1 rounded w-24">
      <button class="border px-3 rounded">Tambah ke Keranjang</button>
    </form>
    @endauth
  </div>
</div>

@if($related->count())
  <h3 class="mt-8 font-semibold">Produk terkait</h3>
  <div class="grid md:grid-cols-4 gap-4 mt-2">
    @foreach($related as $r)
      <a class="border rounded p-2 hover:underline" href="{{ route('products.show',$r) }}">{{ $r->name }}</a>
    @endforeach
  </div>
@endif
@endsection
