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
      <form method="GET" class="inline-block">
        <label for="admin-sort" class="sr-only">Sort by</label>
        <select id="admin-sort" name="sort" onchange="this.form.submit()" class="px-3 py-2 rounded bg-[#113737] text-white">
          <option value="latest" {{ (isset($sort) && $sort === 'latest') ? 'selected' : '' }}>Latest</option>
          <option value="price_asc" {{ (isset($sort) && $sort === 'price_asc') ? 'selected' : '' }}>Price: Low → High</option>
          <option value="price_desc" {{ (isset($sort) && $sort === 'price_desc') ? 'selected' : '' }}>Price: High → Low</option>
          <option value="name_asc" {{ (isset($sort) && $sort === 'name_asc') ? 'selected' : '' }}>Name: A → Z</option>
          <option value="name_desc" {{ (isset($sort) && $sort === 'name_desc') ? 'selected' : '' }}>Name: Z → A</option>
        </select>
      </form>
    </div>
  </div>

  <div class="grid grid-cols-12 gap-6">
    <!-- Left: form -->
    <div class="col-span-3 border rounded-lg p-6 bg-[#07221F]">
      <form id="product-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        <div>
          <label class="block mb-1 text-sm">Name</label>
        <input type="text" name="name" id="product-name" required class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white">
        </div>

        <div>
          <label class="block mb-1 text-sm">Price</label>
        <input type="number" name="price" id="product-price" required class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white">
        </div>

        <div>
          <label class="block mb-1 text-sm">Categories</label>
            <select name="category_id" id="product-category" class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white">
            <option value="">-- Select --</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block mb-1 text-sm">Stock</label>
        <input type="number" name="stock" id="product-stock" class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white">
        </div>

        <div>
          <label class="block mb-1 text-sm">Color</label>
        <input type="text" name="color" id="product-color" class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white" placeholder="comma separated">
        </div>

        <div>
          <label class="block mb-1 text-sm">Size</label>
        <input type="text" name="size" id="product-size" class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white" placeholder="comma separated">
        </div>

        <div>
          <label class="block mb-1 text-sm">Image</label>
        <input type="file" name="image" id="product-image" accept="image/*" class="w-full text-sm text-white">
        <div id="image-preview" class="mt-2 h-40 w-full bg-gray-800 flex items-center justify-center text-gray-400">Preview</div>
        </div>

        <div>
          <label class="block mb-1 text-sm">Description</label>
        <textarea name="description" id="product-description" rows="4" class="w-full px-3 py-2 rounded bg-[#0F3B38] text-white"></textarea>
        </div>

        <div>
            <div class="flex gap-2">
              <button type="submit" id="form-submit" class="bg-[#D2B48C] text-black px-4 py-2 rounded">Add Product</button>
              <button type="button" id="form-cancel" class="bg-gray-600 text-white px-4 py-2 rounded hidden">Cancel</button>
            </div>
        </div>
      </form>
    </div>

    <!-- Right: product grid -->
    <div class="col-span-9">
      <div class="border rounded-lg p-4 bg-[#073231]">
        <div class="grid grid-cols-4 gap-6">
          @foreach ($products as $product)
              <div tabindex="0" role="button" class="bg-white text-black rounded-lg overflow-hidden shadow cursor-pointer product-card" data-id="{{ $product->id }}" data-name="{{ e($product->name) }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}" data-category="{{ $product->category_id }}" data-color="{{ e($product->color ?? '') }}" data-size="{{ e($product->size ?? '') }}" data-description="{{ e($product->description ?? '') }}" data-image="{{ $product->image_path ? asset('storage/'.$product->image_path) : '' }}">
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
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" onclick="event.stopPropagation(); return confirm('Delete product?')" class="text-sm px-3 py-1 bg-red-600 text-white rounded">Delete</button>
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

          @push('scripts')
          <script>
            (function(){
              const cards = document.querySelectorAll('.product-card');
              const form = document.getElementById('product-form');
              const methodInput = document.getElementById('form-method');
              const submitBtn = document.getElementById('form-submit');
              const cancelBtn = document.getElementById('form-cancel');

              if (!form || !methodInput || !submitBtn || !cancelBtn) return;

              const fields = {
                name: document.getElementById('product-name'),
                price: document.getElementById('product-price'),
                category: document.getElementById('product-category'),
                stock: document.getElementById('product-stock'),
                color: document.getElementById('product-color'),
                size: document.getElementById('product-size'),
                description: document.getElementById('product-description'),
                imagePreview: document.getElementById('image-preview')
              };

              function resetForm() {
                form.action = "{{ route('admin.products.store') }}";
                methodInput.value = 'POST';
                submitBtn.textContent = 'Add Product';
                cancelBtn.classList.add('hidden');
                if (fields.name) fields.name.value = '';
                if (fields.price) fields.price.value = '';
                if (fields.category) fields.category.value = '';
                if (fields.stock) fields.stock.value = '';
                if (fields.color) fields.color.value = '';
                if (fields.size) fields.size.value = '';
                if (fields.description) fields.description.value = '';
                if (fields.imagePreview) fields.imagePreview.innerHTML = 'Preview';
              }

              function openCard(card) {
                const id = card.dataset.id;
                const name = card.dataset.name || '';
                const price = card.dataset.price || '';
                const stock = card.dataset.stock || '';
                const category = card.dataset.category || '';
                const color = card.dataset.color || '';
                const size = card.dataset.size || '';
                const description = card.dataset.description || '';
                const image = card.dataset.image || '';

                form.action = `/admin/products/${id}`;
                methodInput.value = 'PATCH';
                submitBtn.textContent = 'Update Product';
                cancelBtn.classList.remove('hidden');

                if (fields.name) fields.name.value = name;
                if (fields.price) fields.price.value = price;
                if (fields.category) fields.category.value = category;
                if (fields.stock) fields.stock.value = stock;
                if (fields.color) fields.color.value = color;
                if (fields.size) fields.size.value = size;
                if (fields.description) fields.description.value = description;
                if (fields.imagePreview) {
                  if (image) {
                    fields.imagePreview.innerHTML = `<img src="${image}" class="h-full w-full object-cover" alt="preview">`;
                  } else {
                    fields.imagePreview.innerHTML = 'No Image';
                  }
                }
              }

              cards.forEach(card => {
                // Ignore if card is not an element
                if (!card) return;

                // Click handler (ignore clicks on buttons/links inside the card)
                card.addEventListener('click', function(e){
                  if (e.target.closest('button') || e.target.closest('a') || e.target.closest('form')) return;
                  openCard(card);
                });

                // Keyboard support
                card.addEventListener('keydown', function(e){
                  if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openCard(card);
                  }
                });

                // Prevent delete button clicks from bubbling to card
                const deleteBtn = card.querySelector('button[type="submit"]');
                if (deleteBtn) {
                  deleteBtn.addEventListener('click', function(ev){
                    ev.stopPropagation();
                    // confirm will be handled by existing onclick attribute
                  });
                }
              });

              cancelBtn.addEventListener('click', function(){
                resetForm();
              });

              // initialize
              resetForm();
            })();
          </script>
          @endpush
