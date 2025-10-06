@extends('layouts.app')

@section('content')

<!-- Hero Section untuk T-Shirts -->
<section class="relative py-20 flex items-center justify-center min-h-[70vh] overflow-hidden">
    <!-- Background with gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-[#16302B] via-[#16302B]/95 to-[#A38560]/20"></div>
    
    <!-- Animated background elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-32 h-32 bg-[#A38560] rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-24 h-24 bg-[#E0E0E0] rounded-full animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-[#A38560] rounded-full animate-pulse" style="animation-delay: 2s;"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center max-w-5xl mx-auto">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold leading-tight mb-8">
                    <span class="block text-[#E0E0E0] mb-2" style="font-family: 'Cinzel', serif;">Discover Your Perfect</span>
                    <span class="block gradient-text mt-2" style="font-family: 'Sloop Script Bold Two', cursive; font-size: 1.2em;">T-Shirts Collection</span>
                </h1>
            </div>
            
            <div class="animate-fade-in-delay">
                <p class="text-lg md:text-2xl text-[#E0E0E0]/90 mb-12 max-w-3xl mx-auto leading-relaxed">
                    Eksplorasi koleksi t-shirt casual premium kami. Kenyamanan dan gaya yang sempurna untuk aktivitas sehari-hari Anda.
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center animate-slide-left">
                <button onclick="scrollToProducts()" class="group bg-[#A38560] hover:bg-[#8B7355] text-white font-bold py-5 px-10 rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-500 transform hover:scale-105 hover-glow relative overflow-hidden">
                    <span class="relative z-10">Shop T-Shirts Collection</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                </button>
                <a href="{{ route('home') }}" class="border-2 border-[#A38560] text-[#A38560] hover:bg-[#A38560] hover:text-white font-bold py-5 px-10 rounded-xl transition-all duration-500 transform hover:scale-105 hover:shadow-xl">
                    View All Categories
                </a>
            </div>
        </div>
    </div>
    
    <!-- Decorative scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-[#A38560]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Products Section -->
<section id="products-section" class="py-12">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#E0E0E0] mb-4">T-Shirts Collection</h2>
            <div class="w-24 h-1 bg-[#A38560] mx-auto rounded"></div>
        </div>

        @if(isset($selectedCategory) && $products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="product-card rounded-2xl shadow-lg overflow-hidden" style="background-color: #E0E0E0;">
                        <a href="{{ route('products.show', $product) }}" class="block relative z-10">
                            <div class="image-container relative">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="zoom-image w-full h-64 md:h-72 object-cover">
                                @else
                                    <div class="w-full h-64 md:h-72 bg-gradient-to-br from-gray-200 via-gray-300 to-gray-200 flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-gray-500 text-sm">No Image</span>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Enhanced overlay untuk hover effect -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 transition-all duration-500 flex items-end justify-center pb-6 hover-overlay">
                                    <span class="text-white font-bold opacity-0 transition-all duration-500 transform translate-y-4 bg-[#A38560] px-6 py-3 rounded-full shadow-lg btn-shimmer view-details-btn">
                                        View Details
                                    </span>
                                </div>
                                
                                <!-- Badge untuk stock rendah -->
                                @if($product->stock <= 5 && $product->stock > 0)
                                    <div class="absolute top-4 right-4 bg-red-500 text-white text-xs px-3 py-1 rounded-full shadow-lg animate-pulse">
                                        Only {{ $product->stock }} left!
                                    </div>
                                @elseif($product->stock == 0)
                                    <div class="absolute top-4 right-4 bg-gray-800 text-white text-xs px-3 py-1 rounded-full shadow-lg">
                                        Out of Stock
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-6 relative z-10">
                                <h3 class="font-bold text-lg md:text-xl text-[#03110D] mb-3 line-clamp-2 group-hover:text-[#A38560] transition-colors duration-300">
                                    {{ $product->name }}
                                </h3>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-[#A38560] font-bold text-xl">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    @if($product->stock > 5)
                                        <span class="text-xs bg-green-100 text-green-600 px-3 py-1 rounded-full font-medium">
                                            In Stock
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Enhanced Rating & Category -->
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center text-yellow-500 star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                        <span class="text-gray-600 text-sm ml-2 font-medium">(4.8)</span>
                                    </div>
                                    <span class="text-gray-500 text-xs font-medium">
                                        {{ $product->category->name ?? 'T-Shirts' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-lg shadow-lg p-4">
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- No Products Found -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h3 class="text-2xl font-bold text-[#E0E0E0] mb-4">No T-Shirts Available</h3>
                    <p class="text-gray-400 mb-8">
                        We're currently updating our t-shirts collection. Check back soon for new arrivals!
                    </p>
                    <a href="{{ route('home') }}" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                        Browse Other Categories
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
/* Line clamp utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Enhanced shadow effects */
.shadow-3xl {
    box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(163, 133, 96, 0.05);
}

/* Product card hover effects */
.product-card {
    transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    position: relative;
    group: true;
}

.product-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(163, 133, 96, 0.1), rgba(224, 224, 224, 0.1));
    opacity: 0;
    transition: opacity 0.5s ease;
    border-radius: 1rem;
    z-index: 1;
}

.product-card:hover::before {
    opacity: 1;
}

.product-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
}

.product-card:hover .hover-overlay {
    opacity: 1 !important;
}

.product-card:hover .view-details-btn {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

/* Image zoom effect */
.image-container {
    overflow: hidden;
    position: relative;
}

.zoom-image {
    transition: transform 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.product-card:hover .zoom-image {
    transform: scale(1.15);
}

/* Button shimmer effect */
.btn-shimmer {
    position: relative;
    overflow: hidden;
}

.btn-shimmer::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.8s;
}

.btn-shimmer:hover::after {
    left: 100%;
}

/* Responsive improvements */
@media (max-width: 640px) {
    .product-card:hover {
        transform: translateY(-4px) scale(1.01);
    }
}
</style>

<script>
function scrollToProducts() {
    const productsSection = document.getElementById('products-section');
    if (productsSection) {
        productsSection.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Add scroll animations
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observe product cards
    document.querySelectorAll('.product-card').forEach(card => {
        observer.observe(card);
    });
});
</script>

@endsection