@once
<style>
.product-card {
    transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    position: relative;
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

.hover-overlay {
    opacity: 0;
}

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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media (max-width: 640px) {
    .product-card:hover {
        transform: translateY(-4px) scale(1.01);
    }
}
</style>
@endonce

@php
    $resolvedCategory = optional($product->category)->name ?? ($categoryName ?? 'Product');
@endphp

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

            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 transition-all duration-500 flex items-end justify-center pb-6 hover-overlay">
                <span class="text-white font-bold opacity-0 transition-all duration-500 transform translate-y-4 bg-[#A38560] px-6 py-3 rounded-full shadow-lg btn-shimmer view-details-btn">
                    View Details
                </span>
            </div>

            @if(isset($product->stock))
                @if($product->stock <= 5 && $product->stock > 0)
                    <div class="absolute top-4 right-4 bg-red-500 text-white text-xs px-3 py-1 rounded-full shadow-lg animate-pulse">
                        Only {{ $product->stock }} left!
                    </div>
                @elseif($product->stock == 0)
                    <div class="absolute top-4 right-4 bg-gray-800 text-white text-xs px-3 py-1 rounded-full shadow-lg">
                        Out of Stock
                    </div>
                @endif
            @endif
        </div>

        <div class="p-6 relative z-10">
            <h3 class="font-bold text-lg md:text-xl text-[#03110D] mb-3 line-clamp-2">
                {{ $product->name }}
            </h3>

            <div class="flex items-center justify-between mb-4">
                <p class="text-[#A38560] font-bold text-xl">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                @if(isset($product->stock) && $product->stock > 5)
                    <span class="text-xs bg-green-100 text-green-600 px-3 py-1 rounded-full font-medium">
                        In Stock
                    </span>
                @endif
            </div>

            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center text-yellow-500 star-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                    @endfor
                    <span class="text-gray-600 text-sm ml-2 font-medium">(4.8)</span>
                </div>
                <span class="text-gray-500 text-xs font-medium">
                    {{ $resolvedCategory }}
                </span>
            </div>
        </div>
    </a>
</div>
