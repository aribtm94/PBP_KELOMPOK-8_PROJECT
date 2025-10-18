@extends('layouts.app')

@section('content')
<div class="p-6 bg-[#0E2D2D] text-white rounded-lg shadow-md">

  {{-- Tombol Kembali ke Dashboard --}}
  <div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" 
       class="bg-gray-700 text-white px-3 py-1 rounded hover:bg-gray-600 transition">
      ← Dashboard
    </a>
  </div>

  {{-- Judul Halaman --}}
  <h1 class="text-xl font-bold mb-4">Kelola Produk</h1>

  {{-- Form Tambah Produk --}}
  <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-4">
    @csrf
    <div>
      <label class="block mb-1 text-sm">Nama Produk</label>
      <input type="text" name="name" class="w-full p-2 rounded bg-[#1A3D3D] text-white border-none focus:ring focus:ring-[#D2B48C]">
    </div>

    <div>
      <label class="block mb-1 text-sm">Kategori</label>
      <select name="category_id" class="w-full p-2 rounded bg-[#1A3D3D] text-white border-none">
        @foreach ($categories as $category)
          <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block mb-1 text-sm">Harga</label>
      <input type="number" name="price" class="w-full p-2 rounded bg-[#1A3D3D] text-white border-none">
    </div>

    <div>
      <label class="block mb-1 text-sm">Stok</label>
      <input type="number" name="stock" class="w-full p-2 rounded bg-[#1A3D3D] text-white border-none">
    </div>

    <div class="col-span-2">
      <label class="block mb-1 text-sm">Foto Produk</label>
      <input type="file" name="image" class="w-full text-sm text-gray-300">
    </div>

    <div class="col-span-2 flex items-center">
      <input type="checkbox" name="is_active" id="is_active" checked class="mr-2">
      <label for="is_active" class="text-sm">Aktif</label>
    </div>

    <div class="col-span-2">
      <label class="block mb-1 text-sm">Deskripsi</label>
      <textarea name="description" rows="3" class="w-full p-2 rounded bg-[#1A3D3D] text-white border-none"></textarea>
    </div>

    <div class="col-span-2">
      <button type="submit" class="bg-[#D2B48C] text-black font-semibold px-4 py-2 rounded hover:opacity-90">
        Tambah Produk
      </button>
    </div>
  </form>

</div>
@endsection
