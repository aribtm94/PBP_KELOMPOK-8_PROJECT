@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-xl font-bold" style="color: #E0E0E0;">Admin • Produk</h1>
  <a href="{{ route('admin.orders.index') }}" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
    📋 Lihat Pesanan User
  </a>
</div>

{{-- Flash & error --}}
@if(session('success')) <div class="bg-[#A38560]/20 border border-[#A38560]/30 p-2 mb-3 rounded" style="color: #E0E0E0;">{{ session('success') }}</div> @endif
@if(session('error'))   <div class="bg-red-500/20 border border-red-500/30 p-2 mb-3 rounded" style="color: #E0E0E0;">{{ session('error') }}</div>   @endif
@if($errors->any())
  <div class="bg-red-500/20 border border-red-500/30 p-2 mb-3 rounded">
    @foreach($errors->all() as $e) <div style="color: #E0E0E0;">{{ $e }}</div> @endforeach
  </div>
@endif

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-3 mb-6">
  @csrf
  <input name="name" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" placeholder="Nama" value="{{ old('name') }}" required>

  <select name="category_id" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;">
    <option value="">(Kategori)</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
    @endforeach
  </select>

  <input name="price" type="number" min="0" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" placeholder="Harga" value="{{ old('price') }}" required>
  <input name="stock" type="number" min="0" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" placeholder="Stok" value="{{ old('stock') }}" required>

  <input name="image" type="file" accept="image/*" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;">
  <label class="flex items-center gap-2" style="color: #E0E0E0;"><input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}> Aktif</label>

  <textarea name="description" rows="3" class="border p-2 rounded md:col-span-2" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" placeholder="Deskripsi">{{ old('description') }}</textarea>

  <div class="md:col-span-2">
    <button type="submit" class="border px-3 py-2 rounded" style="color: #E0E0E0; border-color: #E0E0E0;">Tambah Produk</button>
  </div>
</form>

{{-- Edit Form (Hidden by default) --}}
<div id="editFormContainer" class="hidden">
  <h2 class="text-lg font-bold mb-4" style="color: #E0E0E0;">Edit Produk</h2>
  <form id="editForm" method="POST" action="" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-3 mb-6">
  @csrf
  @method('PATCH')
  
  <input id="editName" name="name" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" placeholder="Nama" required>

  <select id="editCategoryId" name="category_id" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;">
    <option value="">(Kategori)</option>
    @foreach($categories as $c)
      <option value="{{ $c->id }}">{{ $c->name }}</option>
    @endforeach
  </select>

  <input id="editPrice" name="price" type="number" min="0" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" placeholder="Harga" required>
  <input id="editStock" name="stock" type="number" min="0" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" placeholder="Stok" required>

  <input name="image" type="file" accept="image/*" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;">
  <label class="flex items-center gap-2" style="color: #E0E0E0;"><input id="editIsActive" type="checkbox" name="is_active" value="1"> Aktif</label>

  <textarea id="editDescription" name="description" rows="3" class="border p-2 rounded md:col-span-2" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;" placeholder="Deskripsi"></textarea>

  <div class="md:col-span-2">
    <button type="submit" class="border px-3 py-2 rounded mr-2" style="color: #E0E0E0; border-color: #E0E0E0;">Update Produk</button>
    <button type="button" onclick="cancelEdit()" class="border px-3 py-2 rounded" style="color: #E0E0E0; border-color: #E0E0E0;">Batal</button>
  </div>
  </form>
</div>

<table class="w-full border rounded" style="border-color: #E0E0E0;">
  <tr class="bg-gray-50">
    <th class="p-2 text-left" style="color: #E0E0E0;">Nama</th><th style="color: #E0E0E0;">Kategori</th><th style="color: #E0E0E0;">Harga</th><th style="color: #E0E0E0;">Stok</th><th style="color: #E0E0E0;">Aktif</th><th></th>
  </tr>
  @foreach($products as $p)
    <tr class="border-t" style="border-color: #E0E0E0;">
      <td class="p-2" style="color: #E0E0E0;">{{ $p->name }}</td>
      <td class="text-center" style="color: #E0E0E0;">{{ $p->category->name ?? '-' }}</td>
      <td class="text-center" style="color: #E0E0E0;">Rp {{ number_format($p->price,0,',','.') }}</td>
      <td class="text-center" style="color: #E0E0E0;">{{ $p->stock }}</td>
      <td class="text-center" style="color: #E0E0E0;">{{ $p->is_active ? 'Ya' : 'Tidak' }}</td>
      <td class="text-center">
        <button onclick="editProduct({{ $p->id }}, '{{ addslashes($p->name) }}', {{ $p->category_id ?: 'null' }}, {{ $p->price }}, {{ $p->stock }}, {{ $p->is_active ? 1 : 0 }}, '{{ addslashes($p->description ?? '') }}')" class="border px-2 py-1 rounded mr-2" style="color: #E0E0E0; border-color: #E0E0E0;">Edit</button>
        <form method="POST" action="{{ route('admin.products.destroy',$p) }}" onsubmit="return confirmDelete('{{ $p->name }}')" class="inline">
          @csrf @method('DELETE')
          <button type="submit" class="border px-2 py-1 rounded hover:bg-red-600 hover:text-white transition-colors" style="color: #E0E0E0; border-color: #E0E0E0;">Hapus</button>
        </form>
      </td>
    </tr>
  @endforeach
</table>
<div class="mt-3" style="color: #E0E0E0;">{{ $products->links() }}</div>
@endsection

<script>
function editProduct(id, name, categoryId, price, stock, isActive, description) {
    // Hide the add form
    document.querySelector('form[action="{{ route('admin.products.store') }}"]').style.display = 'none';
    
    // Show the edit form container
    const editFormContainer = document.getElementById('editFormContainer');
    const editForm = document.getElementById('editForm');
    editFormContainer.classList.remove('hidden');
    editForm.style.display = 'grid';
    
    // Update the form action to the correct update route
    editForm.action = '/admin/products/' + id;
    
    // Populate the form fields
    document.getElementById('editName').value = name;
    document.getElementById('editCategoryId').value = categoryId || '';
    document.getElementById('editPrice').value = price;
    document.getElementById('editStock').value = stock;
    document.getElementById('editIsActive').checked = isActive == 1;
    document.getElementById('editDescription').value = description;
    
    // Scroll to the form
    editFormContainer.scrollIntoView({ behavior: 'smooth' });
}

function cancelEdit() {
    // Hide the edit form container
    const editFormContainer = document.getElementById('editFormContainer');
    const editForm = document.getElementById('editForm');
    editFormContainer.classList.add('hidden');
    editForm.style.display = 'none';
    
    // Show the add form
    document.querySelector('form[action="{{ route('admin.products.store') }}"]').style.display = 'grid';
    
    // Clear form fields
    document.getElementById('editName').value = '';
    document.getElementById('editCategoryId').value = '';
    document.getElementById('editPrice').value = '';
    document.getElementById('editStock').value = '';
    document.getElementById('editIsActive').checked = false;
    document.getElementById('editDescription').value = '';
}

function confirmDelete(productName) {
    return confirm('Apakah Anda yakin ingin menghapus produk "' + productName + '"?\n\nTindakan ini tidak dapat dibatalkan.');
}
</script>
