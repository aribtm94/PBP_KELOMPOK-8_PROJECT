@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Admin • Produk</h1>

{{-- Flash & error --}}
@if(session('success')) <div class="bg-green-100 p-2 mb-3">{{ session('success') }}</div> @endif
@if(session('error'))   <div class="bg-red-100 p-2 mb-3">{{ session('error') }}</div>   @endif
@if($errors->any())
  <div class="bg-red-100 p-2 mb-3">
    @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
  </div>
@endif

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-3 mb-6">
  @csrf
  <input name="name" class="border p-2 rounded" placeholder="Nama" value="{{ old('name') }}" required>

  <select name="category_id" class="border p-2 rounded">
    <option value="">(Kategori)</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
    @endforeach
  </select>

  <input name="price" type="number" min="0" class="border p-2 rounded" placeholder="Harga" value="{{ old('price') }}" required>
  <input name="stock" type="number" min="0" class="border p-2 rounded" placeholder="Stok" value="{{ old('stock') }}" required>

  <input name="image" type="file" accept="image/*" class="border p-2 rounded">
  <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}> Aktif</label>

  <textarea name="description" rows="3" class="border p-2 rounded md:col-span-2" placeholder="Deskripsi">{{ old('description') }}</textarea>

  <div class="md:col-span-2">
    <button type="submit" class="border px-3 py-2 rounded">Tambah Produk</button>
  </div>
</form>

<table class="w-full border rounded">
  <tr class="bg-gray-50">
    <th class="p-2 text-left">Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aktif</th><th></th>
  </tr>
  @foreach($products as $p)
    <tr class="border-t">
      <td class="p-2">{{ $p->name }}</td>
      <td class="text-center">{{ $p->category->name ?? '-' }}</td>
      <td class="text-center">Rp {{ number_format($p->price,0,',','.') }}</td>
      <td class="text-center">{{ $p->stock }}</td>
      <td class="text-center">{{ $p->is_active ? 'Ya' : 'Tidak' }}</td>
      <td class="text-center">
        {{-- contoh hapus cepat --}}
        <form method="POST" action="{{ route('admin.products.destroy',$p) }}" onsubmit="return confirm('Hapus?')">
          @csrf @method('DELETE')
          <button class="border px-2 py-1 rounded">Hapus</button>
        </form>
      </td>
    </tr>
  @endforeach
</table>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
