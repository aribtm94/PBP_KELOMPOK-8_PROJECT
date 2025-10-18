@extends('layouts.app')

@section('content')

@php
  $isSearching = request()->filled('search');
@endphp

@if(isset($debugMessage))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <strong>Debug Info:</strong> {{ $debugMessage }}
</div>
@endif

@if(isset($selectedCategory))
<div class="container mx-auto px-6 py-8">
    <h2 class="text-3xl font-bold mb-6" style="color: #E0E0E0;">{{ $selectedCategory->name }} Products</h2>
    
    @if($products->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      @foreach($products as $product)
        @include('products.partials.product-card', [
          'product' => $product,
          'categoryName' => $selectedCategory->name
        ])
      @endforeach
    </div>

    @if($products->hasPages())
      <div class="mt-12 flex justify-center">
        <div class="bg-white rounded-lg shadow-lg p-4">
          {{ $products->links() }}
        </div>
      </div>
    @endif
        
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-xl">No products found in this category.</p>
            <p class="text-gray-400 mt-2">Products may not be assigned to this category or may be inactive.</p>
        </div>
    @endif
</div>
@endif

@if($isSearching)
<section id="search-results" class="py-12">
  <div class="container mx-auto px-6">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold text-[#E0E0E0] mb-3">Hasil Pencarian</h2>
      <p class="text-gray-400 text-sm md:text-base">Menampilkan produk untuk <span class="text-[#A38560] font-semibold">"{{ request('search') }}"</span></p>
    </div>

    @if($products->count() > 0)
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($products as $product)
          @include('products.partials.product-card', ['product' => $product])
        @endforeach
      </div>

      @if($products->hasPages())
        <div class="mt-12 flex justify-center">
          <div class="bg-white rounded-lg shadow-lg p-4">
            {{ $products->links() }}
          </div>
        </div>
      @endif
    @else
      <div class="text-center py-16">
        <div class="max-w-md mx-auto">
          <svg class="mx-auto h-16 w-16 text-gray-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
          <h3 class="text-2xl font-bold text-[#E0E0E0] mb-4">Produk Tidak Ditemukan</h3>
          <p class="text-gray-400 mb-8">Coba gunakan kata kunci lain atau jelajahi kategori produk kami.</p>
          <a href="{{ route('home') }}" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
            Kembali ke Beranda
          </a>
        </div>
      </div>
    @endif
  </div>
</section>

@endif

@if(!isset($selectedCategory) && !$isSearching)
<!-- Hero Section -->
<section class="py-16 flex items-center justify-center">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-800 leading-tight">
                <span id="full-animated-text" class="block min-h-[80px] md:min-h-[120px] lg:min-h-[160px]"></span>
            </h1>
            <div class="mt-8">
                <button onclick="scrollToProducts()" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-semibold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    Explore Collection
                </button>
            </div>
        </div>
    </div>
</section>
@endif

@if(!isset($selectedCategory) && !$isSearching)
<!-- Grid Produk (8 Gambar Kecil) - Hanya tampil di halaman utama -->
<div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-4 gap-8 mb-12 mt-8">
@php
$isSearching = request()->filled('search');
$displayProducts = $isSearching ? $products : $products->take(8);
$productCount = $displayProducts->count();
@endphp

@foreach($displayProducts as $p)
  <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <a href="{{ route('products.show',$p) }}" class="block">
      @if($p->image_path)
        <img src="{{ asset('storage/'.$p->image_path) }}" alt="{{ $p->name }}" class="w-full h-72 object-cover hover:scale-105 transition-transform duration-300">
      @else
        <div class="w-full h-72 bg-gray-200 flex items-center justify-center">
          <span class="text-gray-500 text-sm">No Image</span>
        </div>
      @endif
    </a>
  </div>
@endforeach

@if(!$isSearching)
  @for($i = $productCount; $i < 8; $i++)
    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
      <div class="w-full h-72 bg-gray-100 flex items-center justify-center">
        <span class="text-gray-400 text-sm">Coming Soon</span>
      </div>
    </div>
  @endfor
@endif
</div>


<!-- Sekilas Produk Carousel - Lebar Penuh dengan Pratinjau (Responsive) -->
<div class="mt-12 w-full">
  <div class="relative overflow-hidden">
    <!-- Wadah Carousel -->
    <div id="carousel-container" class="flex items-center gap-2 sm:gap-4 md:gap-6 py-6 sm:py-8 md:py-12 px-2 sm:px-6 md:px-12 lg:px-16 transition-transform duration-500 ease-out">
      <!-- Gambar Sebelumnya (Pratinjau Kiri) -->
      <div class="carousel-item prev flex-shrink-0 opacity-50 scale-75 transition-all duration-500">
        <img id="prev-image" src="{{ asset('images/Product/Pants/Gambar2.png') }}" alt="Previous" class="h-40 sm:h-56 md:h-72 lg:h-80 w-auto object-cover rounded-lg shadow-lg" style="cursor:pointer;">
      </div>
      <!-- Gambar Saat Ini (Fokus Tengah) -->
      <div class="carousel-item current flex-shrink-0 opacity-100 scale-100 transition-all duration-500">
        <img id="current-image" src="{{ asset('images/Product/Outerwear/Gambar2.png') }}" alt="Current" class="h-48 sm:h-64 md:h-80 lg:h-96 w-auto object-cover rounded-lg shadow-2xl">
      </div>
      <!-- Gambar Selanjutnya (Pratinjau Kanan) -->
      <div class="carousel-item next flex-shrink-0 opacity-50 scale-75 transition-all duration-500">
        <img id="next-image" src="{{ asset('images/Product/Outerwear/Gambar1.png') }}" alt="Next" class="h-40 sm:h-56 md:h-72 lg:h-80 w-auto object-cover rounded-lg shadow-lg" style="cursor:pointer;">
      </div>
    </div>
    <!-- Navigation Arrows -->
    <button onclick="changeImage('left')" class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-70 text-white rounded-full p-2 sm:p-3 shadow-xl z-30 transition-all duration-300 hover:scale-110">
      <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </button>
    <button onclick="changeImage('right')" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-70 text-white rounded-full p-2 sm:p-3 shadow-xl z-30 transition-all duration-300 hover:scale-110">
      <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
      </svg>
    </button>
  </div>
</div>
<!-- Product Categories Sections -->
@if(!isset($selectedCategory))
<!-- Shirt Section -->
<section id="product-sections" class="py-12">
    <div class="container mx-auto px-6">
        <!-- Shirt Products -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-90 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/Shirt/Shirt Hitam OverBoxy.png" alt="Shirt Product 1" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-90 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/Shirt/Shirt Navy Body Fit.png" alt="Shirt Product 2" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-90 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/Shirt/Shirt Two Tone Oversize.png" alt="Shirt Product 3" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
        <!-- View All Button -->
    <div class="text-center mb-8">
      <a href="{{ route('kaos') }}" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 inline-block">
        view all products
      </a>
    </div>
        <!-- Slider Images -->
        <div class="relative overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out" id="shirt-slider">
                <div class="min-w-full">
                    <img src="/images/Product/Shirt/Gambar1.png" alt="Shirt Slide 1" class="w-full h-64 object-cover rounded-lg">
                </div>
                <div class="min-w-full">
                    <img src="/images/Product/Shirt/Gambar2.png" alt="Shirt Slide 2" class="w-full h-64 object-cover rounded-lg">
                </div>
                
            </div>
            <button onclick="slideShirt('left')" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button onclick="slideShirt('right')" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- T-Shirt Section -->
<section class="py-12">
    <div class="container mx-auto px-6">
        <!-- T-Shirt Products -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/T-Shirt/Corduroy Brown Overshirt.png" alt="T-Shirt Product 1" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/T-Shirt/Tshirt Light Gray Relaxed Fit.png" alt="T-Shirt Product 2" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/T-Shirt/Yanded Brown Stripe Tshirt.png" alt="T-Shirt Product 3" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
        <!-- View All Button -->
      <div class="text-center mb-8">
        <a href="{{ route('kemeja') }}" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 inline-block">
          view all products
        </a>
      </div>
        <!-- Slider Images -->
        <div class="relative overflow-hidden">
          <div class="flex transition-transform duration-500 ease-out" id="tshirt-slider">
            <div class="min-w-full">
              <img src="/images/Product/T-Shirt/Gambar1.webp" alt="T-Shirt Slide 1" class="w-full h-64 object-cover rounded-lg">
            </div>
          </div>
        </div>
    </div>
</section>

<!-- Pants Section -->
<section class="py-12">
    <div class="container mx-auto px-6">
        <!-- Pants Products -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/Pants/Short Sweatpants White.png" alt="Pants Product 1" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/Pants/Stripes Pants Black.png" alt="Pants Product 2" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/Pants/Summer Gurkha Pants Brown.png" alt="Pants Product 3" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
        <!-- View All Button -->
      <div class="text-center mb-8">
        <a href="{{ route('pants') }}" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 inline-block">
          view all products
        </a>
      </div>
        <!-- Slider Images -->
        <div class="relative overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out" id="pants-slider">
                <div class="min-w-full">
                    <img src="/images/Product/Pants/Gambar1.png" alt="Pants Slide 1" class="w-full h-64 object-cover rounded-lg">
                </div>
                <div class="min-w-full">
                    <img src="/images/Product/Pants/Gambar2.png" alt="Pants Slide 2" class="w-full h-64 object-cover rounded-lg">
                </div>
                <div class="min-w-full">
                    <img src="/images/Product/Pants/Gambar3.png" alt="Pants Slide 3" class="w-full h-64 object-cover rounded-lg">
                </div>
            </div>
            <button onclick="slidePants('left')" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button onclick="slidePants('right')" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Outerwear Section -->
<section class="py-12">
    <div class="container mx-auto px-6">
        <!-- Outerwear Products -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/Outerwear/Wool Fiber Green Jacket.png" alt="Outerwear Product 1" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/Outerwear/Subtle Stripes Jacket.png" alt="Outerwear Product 2" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                    <img src="/images/Product/Outerwear/Corduroy Work Jacket Button.png" alt="Outerwear Product 3" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
        <!-- View All Button -->
      <div class="text-center mb-8">
        <a href="{{ route('jaket') }}" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 inline-block">
          view all products
        </a>
      </div>
        <!-- Slider Images -->
        <div class="relative overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out" id="outerwear-slider">
                <div class="min-w-full">
                    <img src="/images/Product/Outerwear/Gambar1.png" alt="Outerwear Slide 1" class="w-full h-64 object-cover rounded-lg">
                </div>
                <div class="min-w-full">
                    <img src="/images/Product/Outerwear/Gambar2.png" alt="Outerwear Slide 2" class="w-full h-64 object-cover rounded-lg">
                </div>
                <div class="min-w-full">
                    <img src="/images/Product/Outerwear/Gambar3.webp" alt="Outerwear Slide 3" class="w-full h-64 object-cover rounded-lg">
                </div>
            </div>
            <button onclick="slideOuterwear('left')" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button onclick="slideOuterwear('right')" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</section>
@endif

<script>
let currentIndex = 0;
const totalItems = 6;

// Array sumber gambar
const images = [
  "{{ asset('images/Product/Outerwear/Gambar2.png') }}",
  "{{ asset('images/Product/Outerwear/Gambar1.png') }}",
  "{{ asset('images/Product/Shirt/Gambar1.png') }}",
  "{{ asset('images/Product/Shirt/Gambar2.png') }}",
  "{{ asset('images/Product/Pants/Gambar1.png') }}",
  "{{ asset('images/Product/Pants/Gambar2.png') }}"
];

function getPrevIndex() {
  return currentIndex > 0 ? currentIndex - 1 : totalItems - 1;
}

function getNextIndex() {
  return currentIndex < totalItems - 1 ? currentIndex + 1 : 0;
}

function updateImages() {
  const prevImg = document.getElementById('prev-image');
  const currentImg = document.getElementById('current-image');
  const nextImg = document.getElementById('next-image');
  
  prevImg.src = images[getPrevIndex()];
  currentImg.src = images[currentIndex];
  nextImg.src = images[getNextIndex()];
}

let isAnimating = false;

function changeImage(direction) {
  const container = document.getElementById('carousel-container');
  
  // Allow quick successive clicks with shorter animation
  if (isAnimating) {
    // If already animating, cut it short and start new animation
    container.style.transition = 'all 0.2s ease-out';
    container.style.opacity = '0.3';
    
    setTimeout(() => {
      performImageChange(direction, container);
    }, 100);
    return;
  }
  
  performImageChange(direction, container);
}

function performImageChange(direction, container) {
  isAnimating = true;
  
  // Transisi responsif cepat
  container.style.transition = 'all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
  container.style.opacity = '0.4';
  container.style.transform = 'scale(0.96)';
  
  // Ubah konten dengan cepat
  setTimeout(() => {
    if (direction === 'left') {
      currentIndex = currentIndex > 0 ? currentIndex - 1 : totalItems - 1;
    } else {
      currentIndex = currentIndex < totalItems - 1 ? currentIndex + 1 : 0;
    }
    
    updateImages();
    
    // Kembalikan dengan cepat
    container.style.opacity = '1';
    container.style.transform = 'scale(1)';
    
    // Reset animasi cepat
    setTimeout(() => {
      isAnimating = false;
    }, 400);
    
  }, 200);
}

// Klik pada gambar pratinjau untuk navigasi
function addPeekClickEvents() {
  const prevImg = document.getElementById('prev-image');
  const nextImg = document.getElementById('next-image');
  
  if (prevImg) {
    prevImg.addEventListener('click', () => changeImage('left'));
    prevImg.style.cursor = 'pointer';
  }
  
  if (nextImg) {
    nextImg.addEventListener('click', () => changeImage('right'));
    nextImg.style.cursor = 'pointer';
  }
}

// Tambahkan navigasi keyboard cepat
let keyPressTimer = null;

function handleKeyPress(direction) {
  if (keyPressTimer) {
    clearTimeout(keyPressTimer);
  }
  
  changeImage(direction);
  
  // Izinkan penekanan tombol yang cepat
  keyPressTimer = setTimeout(() => {
    keyPressTimer = null;
  }, 100);
}

// Inisialisasi carousel
document.addEventListener('DOMContentLoaded', function() {
  updateImages();
  addPeekClickEvents();
  
  // Navigasi keyboard dengan dukungan cepat
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
      e.preventDefault();
      handleKeyPress('left');
    } else if (e.key === 'ArrowRight') {
      e.preventDefault();
      handleKeyPress('right');
    }
  });
});

// Scroll to products function
function scrollToProducts() {
  const productsSection = document.getElementById('product-sections');
  if (productsSection) {
    productsSection.scrollIntoView({ 
      behavior: 'smooth',
      block: 'start'
    });
  }
}

// Slider functions
let shirtIndex = 0;
let tshirtIndex = 0;
let pantsIndex = 0;
let outerwearIndex = 0;

function slideShirt(direction) {
  const slider = document.getElementById('shirt-slider');
  const maxIndex = slider.children.length - 1;
  if (direction === 'right') {
    shirtIndex = (shirtIndex + 1) % (maxIndex + 1);
  } else if (direction === 'left') {
    shirtIndex = (shirtIndex - 1 + (maxIndex + 1)) % (maxIndex + 1);
  }
  slider.style.transform = `translateX(-${shirtIndex * 100}%)`;
}

function slideTShirt(direction) {
  const slider = document.getElementById('tshirt-slider');
  if (direction === 'left') {
    tshirtIndex = tshirtIndex > 0 ? tshirtIndex - 1 : 2;
  } else {
    tshirtIndex = tshirtIndex < 2 ? tshirtIndex + 1 : 0;
  }
  slider.style.transform = `translateX(-${tshirtIndex * 100}%)`;
}

function slidePants(direction) {
  const slider = document.getElementById('pants-slider');
  if (direction === 'left') {
    pantsIndex = pantsIndex > 0 ? pantsIndex - 1 : 2;
  } else {
    pantsIndex = pantsIndex < 2 ? pantsIndex + 1 : 0;
  }
  slider.style.transform = `translateX(-${pantsIndex * 100}%)`;
}

function slideOuterwear(direction) {
  const slider = document.getElementById('outerwear-slider');
  if (direction === 'left') {
    outerwearIndex = outerwearIndex > 0 ? outerwearIndex - 1 : 2;
  } else {
    outerwearIndex = outerwearIndex < 2 ? outerwearIndex + 1 : 0;
  }
  slider.style.transform = `translateX(-${outerwearIndex * 100}%)`;
}

</script>


@endif
@endsection
