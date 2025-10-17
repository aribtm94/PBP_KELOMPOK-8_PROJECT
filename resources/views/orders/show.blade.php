@extends('layouts.app')
@section('content')

<!-- Success Toast (if just created) -->
@if(session('success') || session('order_created'))
<div id="successToast" class="fixed top-4 right-4 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-lg shadow-xl transform translate-x-full transition-transform duration-500 z-50 max-w-sm">
    <div class="flex items-center gap-3">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="font-bold text-sm">Pesanan Berhasil Dibuat!</div>
            <div class="text-xs opacity-90">Terima kasih atas pembelian Anda</div>
        </div>
        <button onclick="closeToast()" class="ml-auto flex-shrink-0 text-white hover:text-gray-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
@endif

<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 bg-[#FBF2E3] shadow-lg rounded-lg p-6">
        <!-- Header with Order Number and Status -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-[#A38560] mb-4">Your Order</h1>
            <div class="mb-4">
                <span class="text-lg text-[#A38560]">Order ID: #<span class="font-semibold text-black">{{ $order->id }}</span></span>
            </div>
            <div class="text-sm text-[#A38560]">Thank you. Your order has been confirmed.</div>
            <div class="mt-4">
                <div class="text-sm text-[#A38560]">
                    <span>Status: <span class="font-semibold text-black">{{ ucfirst($order->status) }}</span></span>
                </div>
                <div class="text-sm text-[#A38560]">
                    <span>Tanggal: <span class="font-semibold text-black">{{ $order->created_at->format('d F Y') }}</span></span>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="bg-[#390517] p-4 mb-6 rounded-lg">
            <div class="font-semibold text-[#FBF2E3]">Shipping Information</div>
            <div class="text-sm text-[#FBF2E3] mt-2">
                <p>Penerima: <span class="font-semibold text-[#A38560]">{{ $order->receiver_name }}</span></p>
                <p>Alamat: <span class="font-semibold text-[#A38560]">{{ $order->address_text }}</span></p>
                <p>Telepon: <span class="font-semibold text-[#A38560]">{{ $order->phone }}</span></p>
            </div>
        </div>

        <!-- Item List -->
        <div class="bg-[#390517] p-4 rounded-lg mb-6">
            <div class="font-semibold text-[#FBF2E3]">Items</div>
            @foreach($order->items as $item)
            <div class="mt-4 border-t pt-4">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-[#FBF2E3]">{{ $item->product->category->name ?? 'Product' }}</div>
                    <div class="text-sm text-[#FBF2E3]">{{ $item->product->name }}</div>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <div class="text-sm text-[#FBF2E3]">Size: {{ $item->size }} | Qty: {{ $item->qty }}</div>
                    <div class="text-lg font-bold text-[#FBF2E3]">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</div>
                </div>
            </div>
            @endforeach
            
            <!-- Total -->
            <div class="mt-4 pt-4 border-t-2 border-[#FBF2E3]">
                <div class="flex justify-between items-center">
                    <div class="text-lg font-bold text-[#FBF2E3]">Total Amount:</div>
                    <div class="text-xl font-bold text-[#FBF2E3]">
                        Rp {{ number_format($order->total_amount ?: $order->items->sum(function($item) { return $item->price * $item->qty; }), 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer with Back Buttons -->
        <div class="mt-6 flex justify-between gap-4">
            <a href="{{ route('home') }}" class="w-full text-center py-2 rounded-lg bg-[#390517] text-white font-semibold hover:bg-[#2a0411] transition-colors">
                Done
            </a>
        </div>
    </div>
</div>

<style>
    /* Success Message Animation */
    .animate-fade-in {
        animation: fadeInUp 0.8s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Success Toast Animation */
    #successToast {
        animation: slideInRight 0.5s ease-out;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    /* Slide out animation */
    .slide-out {
        animation: slideOutRight 0.5s ease-out forwards;
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    /* Pulse effect for toast */
    #successToast {
        animation: slideInRight 0.5s ease-out, pulse 2s ease-in-out 1s;
    }
    
    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }
        50% {
            box-shadow: 0 4px 25px rgba(34, 197, 94, 0.6);
        }
    }
</style>

<script>
// Success Toast Control
document.addEventListener('DOMContentLoaded', function() {
    // Handle back button navigation to prevent flash messages
    if (window.performance && window.performance.navigation.type === 2) {
        // This is a back navigation, reload to clear flash messages
        window.location.reload(true);
        return; // Exit early to prevent toast from showing
    }

    const successToast = document.getElementById('successToast');
    
    if (successToast) {
        // Show toast with slide-in animation
        setTimeout(() => {
            successToast.classList.remove('translate-x-full');
            successToast.classList.add('translate-x-0');
        }, 300);
        
        // Auto hide after 4 seconds
        setTimeout(() => {
            closeToast();
        }, 4000);
    }

    // Handle pageshow event for back button
    window.addEventListener('pageshow', function(event) {
        // Check if page was loaded from cache (back button)
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            // Refresh the page to clear any flash messages
            window.location.reload(true);
        }
    });
});

function closeToast() {
    const successToast = document.getElementById('successToast');
    if (successToast) {
        // Slide out to the right
        successToast.classList.remove('translate-x-0');
        successToast.classList.add('translate-x-full');
        
        // Remove element after animation completes
        setTimeout(() => {
            if (successToast.parentNode) {
                successToast.remove();
            }
        }, 500);
    }
}

// Handle order creation flag
@if(session('success') || session('order_created'))
    // Set flag for back button handling
    sessionStorage.setItem('fromCheckout', 'true');
    console.log('Order created - showing success message');
@endif

// Handle back button behavior for fresh orders
window.addEventListener('popstate', function(event) {
    if (sessionStorage.getItem('fromCheckout') === 'true') {
        console.log('Redirecting to home from fresh order');
        event.preventDefault();
        sessionStorage.removeItem('fromCheckout');
        window.location.replace('{{ route("home") }}');
        return false;
    }
});
</script>

@endsection
