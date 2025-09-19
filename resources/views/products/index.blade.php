@extends('layouts.app')

@section('content')
<form class="flex gap-2 mb-4">
  <input name="search" value="{{ request('search') }}" placeholder="Cari produk…" class="border p-2 rounded w-full">
  <select name="category" class="border p-2 rounded">
    <option value="">Semua Kategori</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}" @selected(request('category')==$c->id)>{{ $c->name }}</option>
    @endforeach
  </select>
  <button class="border px-3 rounded">Cari</button>
</form>

<div class="grid md:grid-cols-4 gap-4">
@foreach($products as $p)
  <div class="border rounded p-3">
    @if($p->image_path)
      <img src="{{ asset('storage/'.$p->image_path) }}" class="w-full h-40 object-cover rounded mb-2">
    @endif
    <a href="{{ route('products.show',$p) }}" class="font-semibold hover:underline">{{ $p->name }}</a>
    <div>Rp {{ number_format($p->price,0,',','.') }}</div>
    <div>{!! $p->stock>0 ? "Stok: $p->stock" : "<span class='text-red-600'>habis</span>" !!}</div>
    @auth
    <form method="POST" action="{{ route('cart.add',$p) }}" class="mt-2 flex gap-2">@csrf
      <input type="number" name="qty" value="1" min="1" class="border p-1 rounded w-20">
      <button class="border px-3 rounded">Tambah</button>
    </form>
    @endauth
  </div>
@endforeach
</div>

<div class="mt-4">{{ $products->links() }}</div>
@endsection
