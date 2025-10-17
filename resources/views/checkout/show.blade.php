@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-8">
        {{-- Main Container --}}
        <div class="bg-[#FBF2E3] rounded-3xl p-8 shadow-lg">
            
            {{-- Header --}}
            <div class="mb-8">
                <a href="{{ route('cart.index') }}" class="font-bold text-gray-700 text-sm mb-4 inline-flex items-center hover:text-gray-900">
                    ← Back to cart
                </a>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Checkout</h1>
                <p class="text-gray-600">a checkout is a counter where you pay for things you are buying</p>
            </div>

            {{-- Error Handling --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    @foreach($errors->all() as $e)
                        <div>{{ $e }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Form Layout --}}
            <form method="POST" action="{{ route('checkout.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @csrf
                


                {{-- Left Column: Form Sections (2 columns) --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- 1. Contact Information --}}
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="bg-gray-900 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">1</span>
                            Contact Information
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <div class="flex items-center border-b-2 border-gray-300 pb-2">
                                    <span class="text-gray-500 mr-3">👤</span>
                                    <div class="w-px h-6 bg-gray-300 mr-3"></div>
                                    <input type="text" name="receiver_name" 
                                           class="flex-1 bg-transparent border-0 focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-500" 
                                           placeholder="First Name" required>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <div class="flex items-center border-b-2 border-gray-300 pb-2">
                                    <span class="text-gray-500 mr-3">👤</span>
                                    <div class="w-px h-6 bg-gray-300 mr-3"></div>
                                    <input type="text" name="last_name" 
                                           class="flex-1 bg-transparent border-0 focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-500" 
                                           placeholder="Last Name" required>
                                </div>
                            </div>
                            
                            <div class="relative">
                                <div class="flex items-center border-b-2 border-gray-300 pb-2">
                                    <span class="text-gray-500 mr-2">🇮🇩</span>
                                    <span class="text-gray-700 mr-2">+62</span>
                                    <div class="w-px h-6 bg-gray-300 mr-3"></div>
                                    <input type="tel" name="phone" id="phone-input"
                                           class="flex-1 bg-transparent border-0 focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-500" 
                                           placeholder="8123456789" 
                                           pattern="^(0?8[0-9]{8,12})$"
                                           title="Masukkan nomor telepon yang valid (08xxxxxxxxx atau 8xxxxxxxxx, maksimal 13 digit)" required>
                                </div>
                                <div id="phone-error" class="text-red-500 text-xs mt-1 hidden"></div>
                            </div>
                            
                            <div class="relative">
                                <div class="flex items-center border-b-2 border-gray-300 pb-2">
                                    <span class="text-gray-500 mr-3">✉️</span>
                                    <div class="w-px h-6 bg-gray-300 mr-3"></div>
                                    <input type="email" name="email" 
                                           class="flex-1 bg-transparent border-0 focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-500" 
                                           placeholder="Email" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Delivery Method --}}
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="bg-gray-900 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">2</span>
                            Delivery Method
                        </h2>
                        
                        <div class="mb-6">
                            <div class="flex items-start border-b-2 border-gray-300 pb-2">
                                <span class="text-gray-500 mr-3 mt-1">📍</span>
                                <div class="w-px h-6 bg-gray-300 mr-3 mt-1"></div>
                                <textarea name="address_text" rows="3" 
                                          class="flex-1 bg-transparent border-0 focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-500 resize-none" 
                                          placeholder="Address" required></textarea>
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <button type="button" data-delivery="same-day" class="px-6 py-2 bg-[#A38560] text-white rounded-full text-sm hover:bg-[#93785A] transition-colors">
                                Same-day<br><span class="text-xs opacity-80">Rp15.000</span>
                            </button>
                            <button type="button" data-delivery="express" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-full text-sm hover:bg-gray-300 transition-colors">
                                Express<br><span class="text-xs opacity-70">Rp10.000</span>
                            </button>
                            <button type="button" data-delivery="regular" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-full text-sm hover:bg-gray-300 transition-colors">
                                Regular<br><span class="text-xs opacity-70">Rp6.000</span>
                            </button>
                        </div>
                        <input type="hidden" name="delivery_method" value="same-day">
                        <input type="hidden" name="delivery_fee" id="delivery-fee-input" value="15000">
                    </div>

                    {{-- 3. Payment Method --}}
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="bg-gray-900 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm mr-3">3</span>
                            Payment Method
                        </h2>
                        
                        <div class="flex gap-4">
                            <button type="button" data-payment="qris" class="px-6 py-2 bg-[#A38560] text-white rounded-full text-sm hover:bg-[#93785A] transition-colors">
                                QRIS
                            </button>
                            <button type="button" data-payment="cod" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-full text-sm hover:bg-gray-300 transition-colors">
                                COD
                            </button>
                            <button type="button" data-payment="transfer" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-full text-sm hover:bg-gray-300 transition-colors">
                                Transfer
                            </button>
                        </div>
                        
                        <input type="hidden" name="payment_method" value="qris">
                    </div>
                </div>

                {{-- Right Column: Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-[#A38560] rounded-2xl p-6 text-white h-fit sticky top-6">
                        <h2 class="text-xl font-bold mb-6 text-center">Order Summary</h2>
                        
                        {{-- Calculate totals --}}
                        @php
                            $subtotal = $cart->total();
                            $deliveryFee = 15000; // Default: Same-day delivery fee
                            $finalTotal = $subtotal + $deliveryFee;
                        @endphp

                        {{-- Price Summary --}}
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-white/80">Sub Total</span>
                                <span class="font-medium">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-white/80">Delivery Fee</span>
                                <span class="font-medium" id="delivery-fee-display">Rp{{ number_format($deliveryFee, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Total Section --}}
                        <div class="border-t border-white/30 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold">Total</span>
                                <span class="text-2xl font-bold" id="total-display">Rp{{ number_format($finalTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Pay Button --}}
                        <button type="submit" 
                                class="w-full bg-[#4A1F2C] hover:bg-[#3A1722] text-white font-bold py-3 px-6 rounded-xl transition-colors duration-200 flex items-center justify-center">
                            Pay
                            <span class="ml-2">→</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delivery method buttons
    const deliveryButtons = document.querySelectorAll('[data-delivery]');
    const deliveryInput = document.querySelector('input[name="delivery_method"]');
    const deliveryFeeInput = document.querySelector('#delivery-fee-input');
    const deliveryFeeDisplay = document.querySelector('#delivery-fee-display');
    const totalDisplay = document.querySelector('#total-display');
    
    // Delivery prices
    const deliveryPrices = {
        'same-day': 15000,
        'express': 10000,
        'regular': 6000
    };
    
    // Order totals
    const subtotal = {{ $subtotal }};
    
    deliveryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const method = this.getAttribute('data-delivery');
            const deliveryFee = deliveryPrices[method] || 6000;
            
            // Remove active class from all buttons
            deliveryButtons.forEach(btn => {
                btn.classList.remove('bg-[#A38560]', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });
            
            // Add active class to clicked button
            this.classList.remove('bg-gray-200', 'text-gray-700');
            this.classList.add('bg-[#A38560]', 'text-white');
            
            // Update hidden input values
            if (deliveryInput) {
                deliveryInput.value = method;
            }
            if (deliveryFeeInput) {
                deliveryFeeInput.value = deliveryFee;
            }
            
            // Update display prices
            updatePriceDisplay(deliveryFee);
        });
    });
    
    function updatePriceDisplay(deliveryFee) {
        // Update delivery fee display
        if (deliveryFeeDisplay) {
            deliveryFeeDisplay.textContent = 'Rp' + deliveryFee.toLocaleString('id-ID');
        }
        
        // Calculate and update total
        const newTotal = subtotal + deliveryFee;
        if (totalDisplay) {
            totalDisplay.textContent = 'Rp' + newTotal.toLocaleString('id-ID');
        }
    }

    // Handle payment method buttons
    const paymentButtons = document.querySelectorAll('[data-payment]');
    const paymentInput = document.querySelector('input[name="payment_method"]');
    
    paymentButtons.forEach(button => {
        button.addEventListener('click', function() {
            const method = this.getAttribute('data-payment');
            
            // Remove active class from all buttons
            paymentButtons.forEach(btn => {
                btn.classList.remove('bg-[#A38560]', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });
            
            // Add active class to clicked button
            this.classList.remove('bg-gray-200', 'text-gray-700');
            this.classList.add('bg-[#A38560]', 'text-white');
            
            // Update hidden input value
            if (paymentInput) {
                paymentInput.value = method;
            }
        });
    });

    // Handle phone number formatting for Indonesia
    const phoneInput = document.querySelector('#phone-input');
    const phoneError = document.querySelector('#phone-error');
    
    if (phoneInput && phoneError) {
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, ''); // Remove non-digits
            let originalValue = this.value;
            
            // Show error if user types non-numeric characters
            if (originalValue !== value) {
                showPhoneError('Nomor telepon hanya boleh berisi angka');
                return;
            }
            
            // Handle different formats
            if (value.startsWith('0')) {
                // Remove leading 0 for display (08xxx -> 8xxx)
                value = value.substring(1);
            }
            
            // Validate and format
            if (value.length > 0) {
                if (!value.startsWith('8')) {
                    showPhoneError('Nomor telepon harus diawali dengan 8 (contoh: 8123456789)');
                    return;
                }
                
                if (value.length < 9) {
                    showPhoneError('Nomor telepon minimal 9 digit setelah 8');
                } else if (value.length > 13) {
                    showPhoneError('Nomor telepon maksimal 13 digit');
                    value = value.substring(0, 13);
                } else {
                    hidePhoneError();
                }
            } else {
                hidePhoneError();
            }
            
            this.value = value;
        });
        
        phoneInput.addEventListener('blur', function() {
            let value = this.value;
            if (value.length > 0 && value.length < 9) {
                showPhoneError('Nomor telepon tidak lengkap');
            }
        });
        
        // Format for backend submission (add leading 0)
        phoneInput.closest('form').addEventListener('submit', function(e) {
            let phoneValue = phoneInput.value;
            if (phoneValue && !phoneValue.startsWith('0')) {
                // Add leading 0 for Indonesian format (8xxx -> 08xxx)
                phoneInput.value = '0' + phoneValue;
            }
        });
    }
    
    function showPhoneError(message) {
        phoneError.textContent = message;
        phoneError.classList.remove('hidden');
        phoneInput.classList.add('border-red-300');
        phoneInput.closest('.border-b-2').classList.add('border-red-300');
    }
    
    function hidePhoneError() {
        phoneError.classList.add('hidden');
        phoneInput.classList.remove('border-red-300');
        phoneInput.closest('.border-b-2').classList.remove('border-red-300');
    }
});
</script>

@endsection
