<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - GayaKu.id</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'forest-green': '#16302B',
                        'light-brown': '#D6C5A1',
                        'medium-brown': '#A38560',
                        'dark-maroon': '#390517',
                        'light-gray': '#E0E0E0',
                        'dark-green': '#03110D'
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar untuk kotak coklat */
        .cart-container::-webkit-scrollbar {
            width: 8px;
        }
        .cart-container::-webkit-scrollbar-track {
            background: #A38560;
            border-radius: 10px;
        }
        .cart-container::-webkit-scrollbar-thumb {
            background: #390517;
            border-radius: 10px;
        }
        .cart-container::-webkit-scrollbar-thumb:hover {
            background: #03110D;
        }
        
        /* Custom input centering */
        .qty-input {
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }
        
        /* Hide number input arrows */
        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .qty-input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body class="m-0 p-0 bg-forest-green h-screen overflow-hidden font-sans">
    <div class="cart-container bg-light-brown m-2 sm:m-5 rounded-2xl p-4 sm:p-8 h-[calc(100vh-1rem)] sm:h-[calc(100vh-2.5rem)] overflow-y-auto">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6 sm:mb-8 text-left text-dark-maroon">Shopping Cart</h1>

            @if($cart->items->isEmpty())
                <div class="text-center text-lg sm:text-xl text-dark-maroon">Your cart is empty.</div>
            @else
                <div class="flex flex-col lg:flex-row justify-center gap-4 lg:gap-8">
                    <!-- Produk Table - Kotak Kiri dengan Rounded -->
                    <div class="w-full lg:w-3/4 bg-white rounded-2xl overflow-hidden shadow-lg">
                        <!-- Mobile: Stack layout -->
                        <div class="block sm:hidden">
                            @foreach($cart->items as $i)
                                <div class="p-4 border-b border-light-gray">
                                    <div class="space-y-2">
                                        <div class="font-semibold text-dark-green">{{ $i->product->name }}</div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-dark-green">Price: Rp {{ number_format($i->product->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <button onclick="decreaseQty({{ $i->id }})" class="bg-light-gray text-dark-maroon px-3 py-1 rounded hover:bg-gray-300 font-bold">-</button>
                                                <input type="number" id="qty-{{ $i->id }}" value="{{ $i->qty }}" min="1" class="qty-input border border-dark-maroon rounded-lg w-16 h-10 text-center text-dark-green focus:outline-none focus:ring-2 focus:ring-medium-brown font-semibold">
                                                <button onclick="increaseQty({{ $i->id }})" class="bg-light-gray text-dark-maroon px-3 py-1 rounded hover:bg-gray-300 font-bold">+</button>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-semibold text-dark-green" data-total-{{ $i->id }}>Rp {{ number_format($i->qty * $i->product->price, 0, ',', '.') }}</div>
                                                <form method="POST" action="{{ route('cart.remove', $i)}}" class="mt-1">
                                                    @method('DELETE') @csrf
                                                    <button class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition-colors">Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Desktop: Table layout -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full min-w-[600px]">
                                <thead class="bg-medium-brown">
                                    <tr>
                                        <th class="p-3 sm:p-4 text-left text-light-gray text-sm sm:text-base">Product</th>
                                        <th class="p-3 sm:p-4 text-center text-light-gray text-sm sm:text-base">Qty</th>
                                        <th class="p-3 sm:p-4 text-center text-light-gray text-sm sm:text-base">Price</th>
                                        <th class="p-3 sm:p-4 text-center text-light-gray text-sm sm:text-base">Total</th>
                                        <th class="p-3 sm:p-4 text-center text-light-gray text-sm sm:text-base">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($cart->items as $i)
                                    <tr class="border-t border-light-gray">
                                        <td class="p-3 sm:p-4 text-left text-dark-green text-sm sm:text-base">{{ $i->product->name }}</td>
                                        <td class="p-3 sm:p-4 text-center text-dark-green">
                                            <div class="flex items-center justify-center gap-1 sm:gap-2">
                                                <button onclick="decreaseQty({{ $i->id }})" class="bg-light-gray text-dark-maroon px-2 sm:px-3 py-1 rounded hover:bg-gray-300 font-bold text-sm sm:text-base">-</button>
                                                <input type="number" id="qty-{{ $i->id }}" value="{{ $i->qty }}" min="1" class="qty-input border border-dark-maroon rounded-lg w-12 sm:w-16 h-8 sm:h-10 text-center text-dark-green focus:outline-none focus:ring-2 focus:ring-medium-brown font-semibold text-sm sm:text-base">
                                                <button onclick="increaseQty({{ $i->id }})" class="bg-light-gray text-dark-maroon px-2 sm:px-3 py-1 rounded hover:bg-gray-300 font-bold text-sm sm:text-base">+</button>
                                            </div>
                                        </td>
                                        <td class="p-3 sm:p-4 text-center text-dark-green text-sm sm:text-base">Rp {{ number_format($i->product->price, 0, ',', '.') }}</td>
                                        <td class="p-3 sm:p-4 text-center text-dark-green text-sm sm:text-base" data-total-{{ $i->id }}>Rp {{ number_format($i->qty * $i->product->price, 0, ',', '.') }}</td>
                                        <td class="p-3 sm:p-4 text-center">
                                            <form method="POST" action="{{ route('cart.remove', $i)}}">
                                                @method('DELETE') @csrf
                                                <button class="bg-red-500 text-white px-2 sm:px-3 py-1 rounded-lg hover:bg-red-600 transition-colors text-xs sm:text-sm">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Order Summary - Kotak Kanan dengan Rounded -->
                    <div class="w-full lg:w-1/4 bg-[#A38560] p-4 sm:p-6 rounded-2xl shadow-lg lg:sticky lg:top-5 h-fit min-h-[300px]">
                        <h3 class="font-bold text-lg sm:text-xl mb-4 text-center text-dark-maroon">Order Summary</h3>
                        
                        <!-- Apply Voucher - Input dan Button Bersebelahan -->
                        <div class="mb-4 sm:mb-6">
                            <h4 class="font-semibold text-dark-maroon mb-2 sm:mb-3 text-sm sm:text-base">Apply Voucher</h4>
                            <div class="flex gap-2 mb-2">
                                <input type="text" id="voucher_code" placeholder="Voucher code" class="flex-1 border border-dark-maroon bg-[#E0E0E0] p-2 rounded-lg text-dark-green focus:outline-none focus:ring-2 focus:ring-medium-brown text-sm sm:text-base min-w-0">
                                <button onclick="applyVoucher()" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors text-sm sm:text-base shrink-0">
                                    Apply
                                </button>
                            </div>
                            <div id="voucher-message" class="text-xs text-center hidden"></div>
                        </div>
                        
                        <div class="space-y-2 sm:space-y-3 mb-4">
                            <div class="flex justify-between text-dark-maroon text-sm sm:text-base">
                                <span>Sub Total</span>
                                <span data-subtotal>Rp {{ number_format($cart->total(), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-dark-maroon text-sm sm:text-base" id="discount-row">
                                <span>Discount</span>
                                <span class="text-green-600" id="discount-amount">-Rp 0</span>
                            </div>
                        </div>
                        
                        <div class="border-t-2 border-dark-maroon pt-3 mb-4 sm:mb-6">
                            <div class="flex justify-between font-bold text-base sm:text-lg text-dark-maroon">
                                <span>Total</span>
                                <span id="final-total" data-final-total>Rp {{ number_format($cart->total(), 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="space-y-2 sm:space-y-3">
                            <a href="{{ route('checkout.show') }}" class="block w-full bg-[#390517] text-light-gray text-center px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity text-sm sm:text-base">
                                Checkout Now
                            </a>
                            <a href="{{ url('/') }}" class="block w-full border-2 border-dark-maroon text-center px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-semibold text-dark-maroon hover:bg-gray-50 transition-colors text-sm sm:text-base">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Update Cart Button - Kembali ke bawah tabel sebelah kiri -->
                <div class="mt-4">
                    <button onclick="updateAllItems()" class="bg-medium-brown text-light-gray px-4 py-2 rounded-lg font-semibold hover:opacity-90 transition-opacity text-sm sm:text-base">
                        Update Cart
                    </button>
                </div>
            @endif
        </div>
    </div>

    <script>
        let appliedDiscount = 0;
        const cartTotal = {{ $cart->total() }};

        // Ensure all quantity inputs are not readonly on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Force remove readonly from all inputs multiple times
            setTimeout(() => {
                const qtyInputs = document.querySelectorAll('.qty-input, input[id*="qty-"]');
                qtyInputs.forEach(input => {
                    input.removeAttribute('readonly');
                    input.readOnly = false;
                    input.disabled = false;
                    console.log('Removed readonly from:', input.id, 'Current value:', input.value);
                });
            }, 100);
            
            // Also remove readonly every 500ms for the first 3 seconds (in case of dynamic loading)
            let attempts = 0;
            const interval = setInterval(() => {
                const qtyInputs = document.querySelectorAll('.qty-input, input[id*="qty-"]');
                qtyInputs.forEach(input => {
                    if (input.hasAttribute('readonly') || input.readOnly) {
                        input.removeAttribute('readonly');
                        input.readOnly = false;
                        console.log('Force removed readonly from:', input.id);
                    }
                });
                attempts++;
                if (attempts >= 6) clearInterval(interval); // Stop after 3 seconds
            }, 500);
            
            // Debug button listeners
            document.querySelectorAll('[onclick*="increaseQty"]').forEach(btn => {
                console.log('Found increase button:', btn);
            });
            
            document.querySelectorAll('[onclick*="decreaseQty"]').forEach(btn => {
                console.log('Found decrease button:', btn);
            });
        });

        function increaseQty(itemId) {
            console.log('=== INCREASE QTY CALLED ===');
            console.log('Item ID:', itemId);
            
            // Try multiple selectors to find the input
            let qtyInput = document.getElementById('qty-' + itemId);
            if (!qtyInput) {
                qtyInput = document.querySelector(`input[id="qty-${itemId}"]`);
            }
            if (!qtyInput) {
                qtyInput = document.querySelector(`.qty-input[id*="${itemId}"]`);
            }
            
            if (!qtyInput) {
                console.error('Input STILL not found for item:', itemId);
                // List all inputs for debugging
                const allInputs = document.querySelectorAll('input[type="number"]');
                console.log('All number inputs found:', allInputs);
                return;
            }
            
            console.log('Found input:', qtyInput);
            console.log('Input readonly?', qtyInput.readOnly);
            console.log('Input disabled?', qtyInput.disabled);
            
            // Completely reset the input
            qtyInput.removeAttribute('readonly');
            qtyInput.removeAttribute('disabled');
            qtyInput.readOnly = false;
            qtyInput.disabled = false;
            
            let currentQty = parseInt(qtyInput.value) || 1;
            console.log('BEFORE - Current qty:', currentQty);
            
            currentQty++;
            console.log('AFTER calculation - New qty:', currentQty);
            
            // Try to set value and immediately verify
            qtyInput.value = currentQty;
            console.log('Set value, now checking:', qtyInput.value);
            
            // Force re-render by hiding and showing
            qtyInput.style.display = 'none';
            setTimeout(() => {
                qtyInput.style.display = '';
                qtyInput.value = currentQty;
                console.log('After force render:', qtyInput.value);
            }, 1);
            
            // Try jQuery if available
            if (window.jQuery) {
                window.jQuery('#qty-' + itemId).val(currentQty);
                console.log('jQuery set value to:', currentQty);
            }
            
            return false; // Prevent any default action
        }

        function decreaseQty(itemId) {
            console.log('=== DECREASE QTY CALLED ===');
            console.log('Item ID:', itemId);
            
            // Try multiple selectors to find the input
            let qtyInput = document.getElementById('qty-' + itemId);
            if (!qtyInput) {
                qtyInput = document.querySelector(`input[id="qty-${itemId}"]`);
            }
            if (!qtyInput) {
                qtyInput = document.querySelector(`.qty-input[id*="${itemId}"]`);
            }
            
            if (!qtyInput) {
                console.error('Input STILL not found for item:', itemId);
                // List all inputs for debugging
                const allInputs = document.querySelectorAll('input[type="number"]');
                console.log('All number inputs found:', allInputs);
                return;
            }
            
            console.log('Found input:', qtyInput);
            console.log('Input readonly?', qtyInput.readOnly);
            console.log('Input disabled?', qtyInput.disabled);
            
            // Completely reset the input
            qtyInput.removeAttribute('readonly');
            qtyInput.removeAttribute('disabled');
            qtyInput.readOnly = false;
            qtyInput.disabled = false;
            
            let currentQty = parseInt(qtyInput.value) || 1;
            console.log('BEFORE - Current qty:', currentQty);
            
            if (currentQty > 1) {
                currentQty--;
                console.log('AFTER calculation - New qty:', currentQty);
                
                // Try to set value and immediately verify
                qtyInput.value = currentQty;
                console.log('Set value, now checking:', qtyInput.value);
                
                // Force re-render by hiding and showing
                qtyInput.style.display = 'none';
                setTimeout(() => {
                    qtyInput.style.display = '';
                    qtyInput.value = currentQty;
                    console.log('After force render:', qtyInput.value);
                }, 1);
                
                // Try jQuery if available
                if (window.jQuery) {
                    window.jQuery('#qty-' + itemId).val(currentQty);
                    console.log('jQuery set value to:', currentQty);
                }
            }
            
            return false; // Prevent any default action
        }

        function updateCartDisplay() {
            // Calculate new totals from current displayed quantities
            let newSubtotal = 0;
            
            @foreach($cart->items as $i)
                const qty{{ $i->id }} = parseInt(document.getElementById('qty-{{ $i->id }}').value);
                const price{{ $i->id }} = {{ $i->product->price }};
                const total{{ $i->id }} = qty{{ $i->id }} * price{{ $i->id }};
                newSubtotal += total{{ $i->id }};
                
                // Update individual total display
                const totalElements{{ $i->id }} = document.querySelectorAll('[data-total-{{ $i->id }}]');
                totalElements{{ $i->id }}.forEach(el => {
                    el.textContent = 'Rp ' + total{{ $i->id }}.toLocaleString('id-ID');
                });
            @endforeach
            
            // Update subtotal
            const subtotalElements = document.querySelectorAll('[data-subtotal]');
            subtotalElements.forEach(el => {
                el.textContent = 'Rp ' + newSubtotal.toLocaleString('id-ID');
            });
            
            // Update final total (considering discount)
            const finalTotal = newSubtotal - appliedDiscount;
            const finalTotalElements = document.querySelectorAll('[data-final-total]');
            finalTotalElements.forEach(el => {
                el.textContent = 'Rp ' + finalTotal.toLocaleString('id-ID');
            });
        }

        async function updateAllItems() {
            const button = document.querySelector('button[onclick="updateAllItems()"]');
            button.disabled = true;
            button.textContent = 'Updating...';
            
            const items = [];
            @foreach($cart->items as $i)
                items.push({
                    id: {{ $i->id }},
                    qty: document.getElementById('qty-{{ $i->id }}').value
                });
            @endforeach
            
            // Update items sequentially
            for (let i = 0; i < items.length; i++) {
                await updateSingleItemAsync(items[i].id, items[i].qty);
                // Small delay between updates
                await new Promise(resolve => setTimeout(resolve, 200));
            }
            
            // Reload page after all updates
            window.location.reload();
        }

        function updateSingleItemAsync(itemId, qty) {
            return new Promise((resolve, reject) => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("cart.update", ":id") }}'.replace(':id', itemId);
                form.style.display = 'none';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PATCH';
                
                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';
                tokenInput.value = '{{ csrf_token() }}';
                
                const qtyInput = document.createElement('input');
                qtyInput.type = 'hidden';
                qtyInput.name = 'qty';
                qtyInput.value = qty;
                
                form.appendChild(methodInput);
                form.appendChild(tokenInput);
                form.appendChild(qtyInput);
                
                // Create iframe for submission to avoid page redirect
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.name = 'updateFrame' + itemId;
                form.target = iframe.name;
                
                document.body.appendChild(iframe);
                document.body.appendChild(form);
                
                iframe.onload = function() {
                    document.body.removeChild(iframe);
                    document.body.removeChild(form);
                    resolve();
                };
                
                form.submit();
            });
        }

        function updateSingleItem(itemId) {
            const qtyInput = document.getElementById('qty-' + itemId);
            const qty = qtyInput.value;
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("cart.update", ":id") }}'.replace(':id', itemId);
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PATCH';
            
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = '{{ csrf_token() }}';
            
            const qtyFormInput = document.createElement('input');
            qtyFormInput.type = 'hidden';
            qtyFormInput.name = 'qty';
            qtyFormInput.value = qty;
            
            form.appendChild(methodInput);
            form.appendChild(tokenInput);
            form.appendChild(qtyFormInput);
            
            document.body.appendChild(form);
            form.submit();
        }

        function applyVoucher() {
            const voucherCode = document.getElementById('voucher_code').value;
            const messageDiv = document.getElementById('voucher-message');
            const discountAmount = document.getElementById('discount-amount');
            const finalTotal = document.getElementById('final-total');
            
            if (!voucherCode.trim()) {
                messageDiv.className = 'text-xs text-center text-red-600';
                messageDiv.textContent = 'Please enter a voucher code';
                messageDiv.classList.remove('hidden');
                return;
            }

            const validVouchers = {
                'GAYAKU10': 10,
                'SAVE20': 20,
                'NEWUSER': 15,
                'WELCOME5': 5
            };

            const upperCode = voucherCode.toUpperCase();
            if (validVouchers[upperCode]) {
                const discountPercent = validVouchers[upperCode];
                appliedDiscount = Math.floor(cartTotal * discountPercent / 100);
                
                messageDiv.className = 'text-xs text-center text-green-600';
                messageDiv.textContent = `${discountPercent}% discount applied!`;
                messageDiv.classList.remove('hidden');
                
                discountAmount.textContent = `-Rp ${appliedDiscount.toLocaleString('id-ID')}`;
                
                const newTotal = cartTotal - appliedDiscount;
                finalTotal.textContent = `Rp ${newTotal.toLocaleString('id-ID')}`;
                
            } else {
                messageDiv.className = 'text-xs text-center text-red-600';
                messageDiv.textContent = 'Invalid voucher code';
                messageDiv.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
