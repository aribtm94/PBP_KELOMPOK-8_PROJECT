@extends('layouts.app')

@section('content')
<div class="p-6 bg-[#0E2D2D] text-white rounded-lg shadow-md">

  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
      <button onclick="location.href='{{ route('admin.dashboard') }}'" class="bg-gray-700 text-white px-3 py-1 rounded hover:bg-gray-600 transition">← Dashboard</button>
      <h1 class="text-3xl font-bold">Product</h1>
    </div>

    <div class="flex items-center gap-3">
      <input type="text" placeholder="Search" class="px-4 py-2 rounded-full text-black w-80" />
      <select class="px-3 py-2 rounded bg-[#113737]">
        <option>Sort by</option>
      </select>
    </div>
  </div>

  <div class="grid grid-cols-12 gap-6">
    <!-- Left: form -->
    <div class="col-span-3 border rounded-lg p-6 bg-[#07221F]">
      <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
          <label class="block mb-1 text-sm">Name</label>
          <input type="text" name="name" required class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white">
        </div>

        <div>
          <label class="block mb-1 text-sm">Price</label>
          <input type="number" name="price" required class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white">
        </div>

        <div>
          <label class="block mb-1 text-sm">Categories</label>
          <select name="category_id" class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white">
            <option value="">-- Select --</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block mb-1 text-sm">Stock</label>
          <input type="number" name="stock" class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white">
        </div>

        <div>
          <label class="block mb-1 text-sm">Color</label>
          <input type="text" name="color" class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white" placeholder="comma separated">
        </div>

        <div>
          <label class="block mb-1 text-sm">Size</label>
          <input type="text" name="size" class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white" placeholder="comma separated">
        </div>

        <div>
          <label class="block mb-1 text-sm">Image</label>
          <input type="file" name="image" accept="image/*" class="w-full text-sm text-white">
        </div>

        <div>
          <label class="block mb-1 text-sm">Description</label>
          <textarea name="description" rows="4" class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white"></textarea>
        </div>

        <div>
          <button type="submit" class="bg-[#D2B48C] text-black px-4 py-2 rounded">Add Product</button>
        </div>
      </form>
    </div>

    <!-- Right: product grid -->
    <div class="col-span-9">
      <div class="border rounded-lg p-4 bg-[#073231]">
        <div class="grid grid-cols-4 gap-6">
          @foreach ($products as $product)
            <div class="bg-white text-black rounded-lg overflow-hidden shadow">
              <div class="h-56 bg-gray-200 flex items-center justify-center">
                @if($product->image_path)
                  <img src="{{ asset('storage/'.$product->image_path) }}" class="h-full w-full object-cover" alt="{{ $product->name }}">
                @else
                  <div class="text-sm text-gray-500">No Image</div>
                @endif
              </div>
              <div class="p-3">
                <div class="text-sm text-gray-600">Rp{{ number_format($product->price,0,',','.') }}</div>
                <div class="font-semibold mt-1">{{ $product->name }}</div>
                <div class="text-xs text-gray-500">{{ $product->category?->name }}</div>
                <div class="mt-3 text-xs text-gray-700">{{ $product->stock }} Stocks</div>
                <div class="mt-3 flex gap-2">
                  <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <button class="text-sm px-3 py-1 bg-[#A38560] text-white rounded">Edit</button>
                  </form>
                  <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete product?')" class="text-sm px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="mt-6">
          {{ $products->links() }}
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
