@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-3">Admin • Produk</h1>
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="border rounded p-3 mb-4">@csrf
  <div class="grid md:grid-cols-3 gap-2">
    <input class="border p-2 rounded" name="name" placeholder="Nama" required>
    <select class="border p-2 rounded" name="category_id">
      <option value="">(Kategori)</option>
      @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
    </select>
    <input class="border p-2 rounded" name="price" type="number" placeholder="Harga" required>
    <input class="border p-2 rounded" name="stock" type="number" placeholder="Stok" required>
    <input class="border p-2 rounded col-span-2" name="image" type="file" accept="image/*">
    <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_active" checked> Aktif</label>
    <textarea class="border p-2 rounded col-span-3" name="description" placeholder="Deskripsi"></textarea>
  </div>
  <button class="mt-2 border px-3 py-1 rounded">Tambah Produk</button>
</form>

<table class="w-full border rounded">
  <tr class="bg-gray-50"><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aktif</th><th>Aksi</th></tr>
  @foreach($products as $p)
  <tr class="border-t">
    <td class="p-2">{{ $p->name }}</td>
    <td>{{ $p->category?->name ?? '-' }}</td>
    <td>Rp {{ number_format($p->price,0,',','.') }}</td>
    <td>{{ $p->stock }}</td>
    <td>{{ $p->is_active ? 'Ya':'Tidak' }}</td>
    <td class="flex gap-2 p-2">
      <form method="POST" action="{{ route('admin.products.update',$p) }}" enctype="multipart/form-data" class="flex gap-2">@csrf @method('PATCH')
        <input name="stock" type="number" value="{{ $p->stock }}" class="border p-1 rounded w-20">
        <label class="inline-flex items-center gap-1 text-sm"><input type="checkbox" name="is_active" {{ $p->is_active?'checked':'' }}>Aktif</label>
        <button class="border px-2 rounded">Simpan</button>
      </form>
      <form method="POST" action="{{ route('admin.products.destroy',$p) }}">@csrf @method('DELETE')
        <button class="border px-2 rounded">Hapus</button>
      </form>
    </td>
  </tr>
  @endforeach
</table>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
