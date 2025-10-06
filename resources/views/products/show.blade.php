@extends('layouts.app')

@section('content')
<!-- Main Product Layout - 4 Kotak -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Kotak 1: Kiri Atas - Product Image -->
    <div class="flex items-start justify-center">
        @if($product->image_path)
            <img src="{{ asset('storage/'.$product->image_path) }}" class="w-72 h-96 object-cover rounded-lg shadow-lg" alt="{{ $product->name }}">
        @endif
    </div>

    <!-- Kotak 2: Kanan Atas - Product Info -->
    <div class="flex flex-col space-y-6">
        <!-- Product Category -->
        <div class="text-2xl lg:text-3xl font-bold text-white">
            {{ $product->category?->name ?? 'Shirts' }}
        </div>
        
        <!-- Product Name -->
        <h1 class="text-lg lg:text-xl font-medium text-white">{{ $product->name }}</h1>
        
        <!-- Price -->
        <div class="text-2xl font-bold text-white">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </div>

        <!-- Color Selection -->
        <div class="space-y-3">
            <label class="text-sm font-bold text-white">Select Color <span class="text-red-400">*</span></label>
            <div class="flex gap-3">
                <button class="w-8 h-8 bg-red-600 rounded-full border-2 border-transparent hover:border-white transition-colors" data-color="red"></button>
                <button class="w-8 h-8 bg-black rounded-full border-2 border-transparent transition-colors hover:border-white" data-color="black"></button>
                <button class="w-8 h-8 bg-amber-800 rounded-full border-2 border-transparent hover:border-white transition-colors" data-color="brown"></button>
            </div>
        </div>

        <!-- Size Selection -->
        <div class="space-y-3">
            <label class="text-sm font-bold text-white">Select Size <span class="text-red-400">*</span></label>
            <div class="flex gap-3">
                <button class="px-4 py-2 border border-white text-white rounded-lg hover:bg-white hover:text-[#16302B] transition-colors font-bold bg-transparent" data-size="S">S</button>
                <button class="px-4 py-2 border border-white text-white rounded-lg hover:bg-white hover:text-[#16302B] transition-colors font-bold bg-transparent" data-size="M">M</button>
                <button class="px-4 py-2 border border-white text-white rounded-lg hover:bg-white hover:text-[#16302B] transition-colors font-bold bg-transparent" data-size="L">L</button>
                <button class="px-4 py-2 border border-white text-white rounded-lg hover:bg-white hover:text-[#16302B] transition-colors font-bold bg-transparent" data-size="XL">XL</button>
                <button class="px-4 py-2 border border-white text-white rounded-lg hover:bg-white hover:text-[#16302B] transition-colors font-bold bg-transparent" data-size="XXL">XXL</button>
            </div>
        </div>

        <!-- Add to Cart Section -->
        @auth
        <form method="POST" action="{{ route('cart.add', $product) }}" class="space-y-4" onsubmit="return validateForm()">
            @csrf
            <input type="hidden" id="selected-color" name="color" value="">
            <input type="hidden" id="selected-size" name="size" value="">
            
            <!-- Error Message Container -->
            <div id="error-message" class="hidden bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                Please select both color and size before adding to cart.
            </div>
            
            <!-- Quantity and Add to Cart -->
            <div class="flex items-center gap-4">
                <div class="flex items-center border border-white rounded-lg">
                    <button type="button" class="px-3 py-2 text-white hover:bg-white hover:text-[#16302B] transition-colors rounded-l-lg" onclick="decreaseQty()">-</button>
                    <input id="qty" name="qty" type="text" value="1" class="w-16 py-2 text-center bg-transparent text-white border-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" readonly>
                    <button type="button" class="px-3 py-2 text-white hover:bg-white hover:text-[#16302B] transition-colors rounded-r-lg" onclick="increaseQty()">+</button>
                </div>
                
                <button type="submit" class="flex-1 bg-[#A38560] text-white py-3 px-6 rounded-lg font-semibold hover:bg-[#8B7355] transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add to Cart
                </button>
            </div>
        </form>
        @endauth
    </div>
</div>

<!-- Description Sections - Full Width -->
<div class="mb-8">
    <div class="grid grid-cols-1 gap-4">
        <!-- Description & Fit Section -->
        <div id="description-box" class="bg-[#390517] rounded-2xl p-6 lg:p-8 slide-box expanded">
            <button type="button" class="flex items-center justify-between w-full text-left" onclick="toggleSection('description'); return false;">
                <h3 class="text-xl font-semibold text-white">Description & Fit</h3>
                <svg id="description-arrow" class="w-6 h-6 text-white rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="description-content" class="mt-4 text-white leading-relaxed slide-content expanded">
                <p>{{ $product->description ?: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe sequi culpa officia nesciunt dolor sit amet consectetur adipisicing elit. Saepe sequi culpa officia nesciunt dolor sit amet consectetur.' }}</p>
            </div>
        </div>
        
        <!-- Product Information Section -->
        <div id="shipping-box" class="bg-[#390517] rounded-2xl p-6 lg:p-8 slide-box collapsed">
            <button type="button" class="flex items-center justify-between w-full text-left" onclick="toggleSection('shipping'); return false;">
                <h3 class="text-xl font-semibold text-white">Product Information</h3>
                <svg id="shipping-arrow" class="w-6 h-6 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="shipping-content" class="mt-4 slide-content collapsed">
                <div class="text-white space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/Ikon Pengiriman.png') }}" alt="Delivery" class="w-6 h-6">
                        <div>
                            <div class="text-sm font-medium text-white">Delivery Time</div>
                            <div class="text-xs text-gray-300">7 - 14 Working Days</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/Ikon Kalender.png') }}" alt="Calendar" class="w-6 h-6">
                        <div>
                            <div class="text-sm font-medium text-white">Estimated Arrival</div>
                            <div class="text-xs text-gray-300">16 - 23 October 2024</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/Package Icon from Figma.png') }}" alt="Package" class="w-6 h-6">
                        <div>
                            <div class="text-sm font-medium text-white">Package</div>
                            <div class="text-xs text-gray-300">Include Package</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/Discount Icon.png') }}" alt="Discount" class="w-6 h-6">
                        <div>
                            <div class="text-sm font-medium text-white">Discount</div>
                            <div class="text-xs text-gray-300">Up to 30% Off</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rating & Review Section - Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
    <!-- Kotak 3: Kiri Bawah - Rating Overview -->
    <div class="p-6 lg:p-8">
        <div class="flex items-center gap-8">
            <!-- Left Side: Rating Score -->
            <div class="text-center">
                <div class="flex items-baseline justify-center mb-2">
                    <span class="text-6xl font-bold text-white">4,5</span>
                    <span class="text-xl text-white ml-1">/ 5</span>
                </div>
                <div class="text-lg text-gray-300">(50 Reviews)</div>
            </div>
            
            <!-- Right Side: Star Rating Bars -->
            <div class="flex-1 space-y-3">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <img src="{{ asset('images/Vector from Figma.png') }}" alt="Star" class="w-4 h-4">
                        <span class="text-white text-sm w-2">5</span>
                    </div>
                    <div class="flex-1 bg-gray-700 rounded-full h-3">
                        <div class="bg-yellow-400 h-3 rounded-full" style="width: 70%"></div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <img src="{{ asset('images/Vector from Figma.png') }}" alt="Star" class="w-4 h-4">
                        <span class="text-white text-sm w-2">4</span>
                    </div>
                    <div class="flex-1 bg-gray-700 rounded-full h-3">
                        <div class="bg-yellow-400 h-3 rounded-full" style="width: 20%"></div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <img src="{{ asset('images/Vector from Figma.png') }}" alt="Star" class="w-4 h-4">
                        <span class="text-white text-sm w-2">3</span>
                    </div>
                    <div class="flex-1 bg-gray-700 rounded-full h-3">
                        <div class="bg-yellow-400 h-3 rounded-full" style="width: 8%"></div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <img src="{{ asset('images/Vector from Figma.png') }}" alt="Star" class="w-4 h-4">
                        <span class="text-white text-sm w-2">2</span>
                    </div>
                    <div class="flex-1 bg-gray-700 rounded-full h-3">
                        <div class="bg-yellow-400 h-3 rounded-full" style="width: 2%"></div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1">
                        <img src="{{ asset('images/Vector from Figma.png') }}" alt="Star" class="w-4 h-4">
                        <span class="text-white text-sm w-2">1</span>
                    </div>
                    <div class="flex-1 bg-gray-700 rounded-full h-3">
                        <div class="bg-yellow-400 h-3 rounded-full" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kotak 4: Kanan Bawah - Reviews Slider -->
    <div class="relative">
        <div class="overflow-hidden rounded-2xl">
            <div id="review-slider" class="flex transition-transform duration-300 ease-in-out">
                <!-- Review 1 -->
                <div class="w-full flex-shrink-0">
                    <div class="bg-[#390517] rounded-2xl p-6 lg:p-8 h-48 flex flex-col border-2 border-[#A38560]/30">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                                <span class="font-bold text-black">L</span>
                            </div>
                            <div>
                                <div class="font-semibold text-white">Leo Messi</div>
                                <div class="flex items-center gap-2">
                                    <div class="flex">
                                        <span class="text-yellow-400">★★★★★</span>
                                    </div>
                                    <span class="text-sm text-[#A38560]">13 October 2025</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-white leading-relaxed break-words flex-1 overflow-hidden">
                            "Produk berkualitas tinggi dengan desain yang sangat bagus. Bahannya nyaman dipakai dan sesuai dengan ekspektasi."
                        </p>
                    </div>
                </div>
                
                <!-- Review 2 -->
                <div class="w-full flex-shrink-0">
                    <div class="bg-[#390517] rounded-2xl p-6 lg:p-8 h-48 flex flex-col border-2 border-[#A38560]/30">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center">
                                <span class="font-bold text-white">A</span>
                            </div>
                            <div>
                                <div class="font-semibold text-white">Ahmad Rizki</div>
                                <div class="flex items-center gap-2">
                                    <div class="flex">
                                        <span class="text-yellow-400">★★★★☆</span>
                                    </div>
                                    <span class="text-sm text-[#A38560]">10 October 2025</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-white leading-relaxed break-words flex-1 overflow-hidden">
                            "Kualitas bagus dan pengiriman cepat. Ukurannya pas sesuai size chart. Recommended!"
                        </p>
                    </div>
                </div>
                
                <!-- Review 3 -->
                <div class="w-full flex-shrink-0">
                    <div class="bg-[#390517] rounded-2xl p-6 lg:p-8 h-48 flex flex-col border-2 border-[#A38560]/30">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 bg-green-400 rounded-full flex items-center justify-center">
                                <span class="font-bold text-white">S</span>
                            </div>
                            <div>
                                <div class="font-semibold text-white">Sari Dewi</div>
                                <div class="flex items-center gap-2">
                                    <div class="flex">
                                        <span class="text-yellow-400">★★★★★</span>
                                    </div>
                                    <span class="text-sm text-[#A38560]">8 October 2025</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-white leading-relaxed break-words flex-1 overflow-hidden">
                            "Sangat merekomendasikan! Modelnya trendy dan cocok untuk berbagai acara."
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation Arrows -->
        <button id="prev-review" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-gray-600 text-white p-2 rounded-full hover:bg-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <button id="next-review" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-gray-600 text-white p-2 rounded-full hover:bg-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>

<script>
// Form validation function
function validateForm() {
    const selectedColor = document.getElementById('selected-color').value;
    const selectedSize = document.getElementById('selected-size').value;
    const errorMessage = document.getElementById('error-message');
    
    if (!selectedColor || !selectedSize) {
        // Show error message
        errorMessage.classList.remove('hidden');
        
        // Hide error message after 5 seconds
        setTimeout(() => {
            errorMessage.classList.add('hidden');
        }, 5000);
        
        return false; // Prevent form submission
    }
    
    // Hide error message if validation passes
    errorMessage.classList.add('hidden');
    return true; // Allow form submission
}

// Color selection
document.querySelectorAll('[data-color]').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active state from all color buttons
        document.querySelectorAll('[data-color]').forEach(btn => {
            btn.classList.remove('border-white');
            btn.classList.add('border-transparent');
        });
        
        // Add active state to clicked button
        this.classList.remove('border-transparent');
        this.classList.add('border-white');
        
        // Update hidden input
        document.getElementById('selected-color').value = this.dataset.color;
        
        // Hide error message when user selects color
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.classList.add('hidden');
        }
    });
});

// Size selection
document.querySelectorAll('[data-size]').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active state from all size buttons
        document.querySelectorAll('[data-size]').forEach(btn => {
            btn.classList.remove('bg-white', 'text-[#16302B]');
            btn.classList.add('bg-transparent', 'text-white');
        });
        
        // Add active state to clicked button
        this.classList.remove('bg-transparent', 'text-white');
        this.classList.add('bg-white', 'text-[#16302B]');
        
        // Update hidden input
        document.getElementById('selected-size').value = this.dataset.size;
        
        // Hide error message when user selects size
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.classList.add('hidden');
        }
    });
});

// Quantity controls
function decreaseQty() {
    const input = document.getElementById('qty');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function increaseQty() {
    const input = document.getElementById('qty');
    const currentValue = parseInt(input.value);
    input.value = currentValue + 1;
}

// Toggle sections with smooth slide animation
function toggleSection(sectionName) {
    const content = document.getElementById(sectionName + '-content');
    const box = document.getElementById(sectionName + '-box');
    const arrow = document.getElementById(sectionName + '-arrow');
    
    // Prevent scroll to top by using event handling
    event.preventDefault();
    
    if (content.classList.contains('collapsed')) {
        // Expand - Arrow rotates immediately, box expands, content appears gradually
        arrow.classList.add('rotate-180');
        box.classList.remove('collapsed');
        box.classList.add('expanded');
        
        // Content appears gradually as box is expanding
        setTimeout(() => {
            content.classList.remove('collapsed');
            content.classList.add('expanded');
        }, 200);
    } else {
        // Collapse - Arrow rotates immediately, box collapses, content fades gradually
        arrow.classList.remove('rotate-180');
        box.classList.remove('expanded');
        box.classList.add('collapsed');
        
        // Content fades out gradually as box is collapsing
        setTimeout(() => {
            content.classList.remove('expanded');
            content.classList.add('collapsed');
        }, 200);
    }
    
    // Prevent any layout shifting
    return false;
}

// Review Slider Functionality
let currentSlide = 0;
const totalSlides = 3;

function updateSlider() {
    const slider = document.getElementById('review-slider');
    const translateX = -currentSlide * 100;
    slider.style.transform = `translateX(${translateX}%)`;
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateSlider();
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateSlider();
}

function goToSlide(slideIndex) {
    currentSlide = slideIndex;
    updateSlider();
}

// Initialize default state
document.addEventListener('DOMContentLoaded', function() {
    // Reset all colors to default state - no auto-selection
    document.querySelectorAll('[data-color]').forEach(btn => {
        btn.classList.remove('border-white');
        btn.classList.add('border-transparent');
    });
    
    // Reset all sizes to default state - no auto-selection
    document.querySelectorAll('[data-size]').forEach(btn => {
        btn.classList.remove('bg-white', 'text-[#16302B]');
        btn.classList.add('bg-transparent', 'text-white');
    });
    
    // Clear the hidden input values
    const colorInput = document.getElementById('selected-color');
    const sizeInput = document.getElementById('selected-size');
    if (colorInput) {
        colorInput.value = '';
    }
    if (sizeInput) {
        sizeInput.value = '';
    }
    
    // Review slider event listeners
    const nextBtn = document.getElementById('next-review');
    const prevBtn = document.getElementById('prev-review');
    
    if (nextBtn && prevBtn) {
        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);
    }
    
    // Auto-slide (optional)
    setInterval(nextSlide, 5000); // Change slide every 5 seconds
});
</script>

<style>
/* Reset scroll color to default */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Ensure text wrapping */
.break-words {
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;
}

/* Slide animation for description sections */
.slide-box {
    transition: max-height 0.5s ease-in-out;
    position: relative;
}

.slide-box.collapsed {
    max-height: 90px; /* Increased to account for container padding (48px top+bottom) + button height */
    overflow: hidden;
}

.slide-box.expanded {
    max-height: 400px; /* Full height */
    overflow: visible;
}

/* Ensure header is always visible */
.slide-box button {
    position: relative;
    z-index: 10;
    background-color: transparent;
    min-height: 40px; /* Reduced height to fit within padding */
    padding: 0; /* Remove padding from button since container has padding */
    display: flex;
    align-items: center; /* Center alignment */
    justify-content: space-between;
    width: 100%;
}

/* Desktop layout - center button content properly */
@media (min-width: 1024px) {
    .slide-box button {
        min-height: 50px; /* Taller button for desktop */
        padding: 8px 0; /* Add some vertical padding for better centering */
    }
    
    .slide-box.collapsed {
        max-height: 110px; /* Increased for desktop padding (lg:p-8 = 32px*2 + button height) */
    }
}

.slide-box button h3 {
    flex: 1;
    text-align: left;
    margin: 0;
    padding: 0;
    line-height: 1.3;
    transform: translateY(0); /* Reset transform - let padding handle positioning */
}

.slide-box button svg {
    margin: 0;
    flex-shrink: 0;
    transform: translateY(0); /* Reset transform - let padding handle positioning */
}

.slide-content {
    transition: opacity 0.2s ease-in-out;
    transition-delay: 0.1s;
    margin-top: 16px;
    position: relative;
    z-index: 5;
}

.slide-content.collapsed {
    opacity: 0;
    transition-delay: 0s;
}

.slide-content.expanded {
    opacity: 1;
    transition-delay: 0.1s;
}

/* Arrow rotation animation - exact same timing as slide */
.slide-box button svg {
    transition: transform 0.5s ease-in-out !important; /* Exact same as slide-box */
    will-change: transform;
}

.slide-box button svg.rotate-180 {
    transform: rotate(180deg) !important;
}

.slide-box button svg:not(.rotate-180) {
    transform: rotate(0deg) !important;
}

/* Responsive text containers */
.review-container {
    max-width: 100%;
    overflow: hidden;
}
</style>

@endsection
