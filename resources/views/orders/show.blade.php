@extends('layouts.app')
@section('content')

<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header with Order Number and Status -->
        <div class="text-center mb-8 fade-in-up">
            <h1 class="text-3xl font-bold text-[#E8DDD4] mb-2">Order Details</h1>
            <div class="flex items-center justify-center gap-4">
                <span class="text-[#A38560] text-lg">Order #{{ $order->id }}</span>
                <span class="px-3 py-1 rounded-full text-sm font-semibold pulse-glow
                    @if($order->status == 'baru') bg-blue-100 text-blue-800
                    @elseif($order->status == 'proses') bg-yellow-100 text-yellow-800
                    @elseif($order->status == 'selesai') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            
            <!-- Progress Bar -->
            <div class="mt-6 mb-8 fade-in-up">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-[#A38560]">Order Progress</span>
                    <span class="text-sm text-[#E8DDD4]">
                        @if($order->status == 'baru') 33%
                        @elseif($order->status == 'proses') 66%
                        @elseif($order->status == 'selesai') 100%
                        @else 0%
                        @endif
                    </span>
                </div>
                <div class="w-full bg-[#390517]/20 rounded-full h-2 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#A38560] to-[#E8DDD4] rounded-full transition-all duration-1000 ease-out"
                         style="width: @if($order->status == 'baru') 33%
                                      @elseif($order->status == 'proses') 66%
                                      @elseif($order->status == 'selesai') 100%
                                      @else 0%
                                      @endif">
                    </div>
                </div>
                <div class="flex justify-between mt-2 text-xs">
                    <span class="text-[#A38560] {{ $order->status == 'baru' || $order->status == 'proses' || $order->status == 'selesai' ? 'font-semibold' : '' }}">New Order</span>
                    <span class="text-[#A38560] {{ $order->status == 'proses' || $order->status == 'selesai' ? 'font-semibold' : '' }}">Processing</span>
                    <span class="text-[#A38560] {{ $order->status == 'selesai' ? 'font-semibold' : '' }}">Completed</span>
                </div>
            </div>
        </div>

        <!-- Success Toast (if just created) -->
        @if(session('success'))
        <div id="successToast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Order Information Card -->
            <div class="bg-gradient-to-br from-[#390517]/20 to-[#390517]/10 backdrop-blur-sm border border-[#A38560]/30 rounded-xl p-6 shadow-lg fade-in-up">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-[#390517] rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#E8DDD4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-[#E8DDD4]">Order Information</h2>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-[#A38560]/20">
                        <span class="text-[#A38560] font-medium">Order Date:</span>
                        <span class="text-[#E8DDD4]">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    
                    <div class="bg-[#390517]/10 rounded-lg p-4 border border-[#A38560]/20">
                        <h3 class="text-[#E8DDD4] font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Delivery Information
                        </h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-[#A38560] text-sm">Recipient:</span>
                                <p class="text-[#E8DDD4] font-medium">{{ $order->receiver_name }}</p>
                            </div>
                            <div>
                                <span class="text-[#A38560] text-sm">Address:</span>
                                <p class="text-[#E8DDD4]">{{ $order->address_text }}</p>
                            </div>
                            <div>
                                <span class="text-[#A38560] text-sm">Phone:</span>
                                <p class="text-[#E8DDD4]">{{ $order->phone ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items Card -->
            <div class="bg-gradient-to-br from-[#390517]/20 to-[#390517]/10 backdrop-blur-sm border border-[#A38560]/30 rounded-xl p-6 shadow-lg fade-in-up">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-[#390517] rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#E8DDD4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-[#E8DDD4]">Order Items</h2>
                </div>
                
                <div class="space-y-3 mb-6">
                    @foreach($order->items as $i)
                        <div class="bg-[#390517]/10 rounded-lg p-4 border border-[#A38560]/20">
                                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-[#E8DDD4] mb-2">{{ $i->product->name }}</h4>
                                        <div class="flex flex-wrap gap-2 text-sm">
                                            <span class="bg-[#A38560]/20 text-[#A38560] px-2 py-1 rounded">
                                                Size: {{ strtoupper($i->size ?? 'N/A') }}
                                            </span>
                                            <span class="bg-[#A38560]/20 text-[#A38560] px-2 py-1 rounded">
                                                Qty: {{ $i->qty }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-left sm:text-right">
                                        <div class="text-sm text-[#A38560] mb-1">@ Rp {{ number_format($i->price,0,',','.') }}</div>
                                        <div class="font-bold text-[#E8DDD4] text-lg">Rp {{ number_format($i->subtotal,0,',','.') }}</div>
                                    </div>
                                </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Total -->
                <div class="border-t border-[#A38560]/30 pt-4">
                    <div class="bg-[#390517]/20 rounded-lg p-4 border border-[#A38560]/40">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-[#A38560]">Total Amount:</span>
                            <span class="text-2xl font-bold text-[#E8DDD4]">Rp {{ number_format($order->total,0,',','.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}" class="group relative overflow-hidden bg-gradient-to-r from-[#390517] to-[#4a0620] text-white px-8 py-4 rounded-xl font-semibold hover:from-[#2a0411] hover:to-[#390517] transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Back to Home
            </a>
            <a href="{{ url('/') }}" class="group border-2 border-[#A38560] text-[#A38560] px-8 py-4 rounded-xl font-semibold hover:bg-[#A38560] hover:text-[#390517] transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Continue Shopping
            </a>
        </div>
    </div>
</div>

<style>
    /* Entrance animations */
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .fade-in-up:nth-child(1) { animation-delay: 0.1s; }
    .fade-in-up:nth-child(2) { animation-delay: 0.2s; }
    .fade-in-up:nth-child(3) { animation-delay: 0.3s; }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Floating animation for cards */
    .floating {
        animation: floating 3s ease-in-out infinite;
    }
    
    @keyframes floating {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
    }
    
    /* Pulse animation for status badge */
    .pulse-glow {
        animation: pulseGlow 2s ease-in-out infinite;
    }
    
    @keyframes pulseGlow {
        0%, 100% { box-shadow: 0 0 5px rgba(59, 130, 246, 0.5); }
        50% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.8); }
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #390517;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #A38560;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #E8DDD4;
    }
</style>

<script>
// Back button control for order page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Order detail page loaded');
    
    // Add entrance animations
    const animatedElements = document.querySelectorAll('.fade-in-up');
    animatedElements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Add floating animation to cards with delay
    setTimeout(() => {
        const cards = document.querySelectorAll('.bg-gradient-to-br');
        cards.forEach(card => {
            card.classList.add('floating');
        });
    }, 800);
    
    // Show success toast if present
    const successToast = document.getElementById('successToast');
    if (successToast) {
        setTimeout(() => {
            successToast.classList.remove('translate-x-full');
        }, 500);
        
        setTimeout(() => {
            successToast.classList.add('translate-x-full');
        }, 4000);
    }
    
    // Check if user came from checkout (fresh order)
    @if(session('prevent_back'))
    // Clear the session flag
    @php session()->forget('prevent_back'); @endphp
    
    // Mark that this order page came from checkout
    sessionStorage.setItem('fromCheckout', 'true');
    console.log('Order came from checkout - back button will redirect to home');
    @endif
    
    // Handle back button - redirect to home if came from checkout
    window.addEventListener('popstate', function(event) {
        console.log('Back button pressed from order page');
        
        // Check if this order page was accessed from checkout
        if (sessionStorage.getItem('fromCheckout') === 'true') {
            console.log('User came from checkout - redirecting to home instead of going back');
            event.preventDefault(); // Prevent default back behavior
            sessionStorage.removeItem('fromCheckout'); // Clean up
            window.location.replace('{{ url("/") }}'); // Use replace to avoid adding to history
            return false;
        }
        
        // Normal back navigation for orders accessed directly
        console.log('Normal back navigation allowed (not from checkout)');
    });
    
    // Additional protection for page refresh/reload
    window.addEventListener('beforeunload', function() {
        // Keep the fromCheckout flag during page reload
        if (sessionStorage.getItem('fromCheckout') === 'true') {
            console.log('Page reloading - preserving fromCheckout flag');
        }
    });
});
</script>

@endsection
