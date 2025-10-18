@extends('layouts.app')

@section('content')
@php $availableSizes = ['S','M','L','XL','XXL']; @endphp

<div class="min-h-screen bg-[#FBF2E3] py-8">
    <div class="max-w-6xl xl:max-w-7xl mx-auto px-2 sm:px-4">
        <div class="bg-transparent rounded-2xl overflow-hidden">
            <div class="bg-transparent px-8 py-6">
                <h1 class="text-5xl font-bold text-[#390517]">Shopping Cart</h1>
            </div>

            <div class="px-8 pb-10">
                @if($cart->items->isEmpty())
                    <div class="text-center py-16">
                        <div class="w-24 h-24 mx-auto mb-6 bg-[#390517]/20 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-[#390517]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4"></path>
                                <circle cx="9" cy="19" r="2"></circle>
                                <circle cx="17" cy="19" r="2"></circle>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#390517] mb-2">Your cart is empty</h3>
                        <p class="text-[#390517] opacity-70 mb-6">Add some products to get started!</p>
                        <a href="{{ url('/') }}" class="bg-[#390517] text-white px-8 py-3 rounded-lg font-medium hover:bg-[#2a0411] transition-colors">Start Shopping</a>
                    </div>
                @else
                    <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="block sm:hidden">
                                @foreach($cart->items as $i)
                                    <div class="p-4 border-b border-[#E0E0E0]">
                                        <div class="space-y-3">
                                            <div class="font-semibold text-[#03110D]">{{ $i->product->name }}</div>
                                            <div class="flex items-center gap-2">
                                                <label class="text-sm text-[#03110D]" for="mobile-size-{{ $i->id }}">Size:</label>
                                                <select id="mobile-size-{{ $i->id }}" data-size-select="{{ $i->id }}" onchange="changeSize({{ $i->id }}, this.value)" class="bg-[#E0E0E0] text-[#03110D] text-sm font-semibold px-3 py-1 rounded focus:outline-none focus:ring-2 focus:ring-[#A38560] w-28">
                                                    @foreach($availableSizes as $size)
                                                        <option value="{{ $size }}" @selected($i->size === $size)>{{ $size }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex items-center justify-between text-sm text-[#03110D]">
                                                <span>Price</span>
                                                <span>Rp {{ number_format($i->product->price, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <button onclick="decreaseQty({{ $i->id }})" class="bg-[#E0E0E0] text-[#390517] px-3 py-1 rounded hover:bg-gray-300 font-bold">-</button>
                                                    <input type="number" id="qty-{{ $i->id }}" value="{{ $i->qty }}" min="1" class="qty-input border border-[#390517] rounded-lg w-16 h-10 text-center text-[#03110D] focus:outline-none focus:ring-2 focus:ring-[#A38560] font-semibold">
                                                    <button onclick="increaseQty({{ $i->id }})" class="bg-[#E0E0E0] text-[#390517] px-3 py-1 rounded hover:bg-gray-300 font-bold">+</button>
                                                </div>
                                                <div class="text-right">
                                                    <div class="font-semibold text-[#03110D]" data-total-{{ $i->id }}>Rp {{ number_format($i->qty * $i->product->price, 0, ',', '.') }}</div>
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

                            <div class="hidden sm:block">
                                <table class="w-full table-fixed">
                                    <colgroup>
                                        <col />
                                        <col class="w-[90px]" />
                                        <col class="w-[120px]" />
                                        <col class="w-[160px] md:w-[180px]" />
                                        <col class="w-[180px] md:w-[200px]" />
                                        <col class="w-[110px]" />
                                    </colgroup>
                                    <thead class="bg-[#A38560]">
                                        <tr>
                                            <th class="px-4 py-4 text-left text-[#E0E0E0] text-sm">Product</th>
                                            <th class="px-4 py-4 text-center text-[#E0E0E0] text-sm">Size</th>
                                            <th class="px-4 py-4 text-center text-[#E0E0E0] text-sm">Qty</th>
                                            <th class="px-4 py-4 text-[#E0E0E0] text-sm text-center whitespace-nowrap tabular-nums">Price</th>
                                            <th class="px-4 py-4 text-[#E0E0E0] text-sm text-center whitespace-nowrap tabular-nums">Total</th>
                                            <th class="px-4 py-4 text-center text-[#E0E0E0] text-sm">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart->items as $i)
                                            <tr class="border-t border-[#E0E0E0]">
                                                <td class="p-4 text-[#03110D] text-sm align-top">{{ $i->product->name }}</td>
                                                <td class="px-4 py-4 text-center text-[#03110D] text-sm font-semibold">
                                                    <select id="desktop-size-{{ $i->id }}" data-size-select="{{ $i->id }}" onchange="changeSize({{ $i->id }}, this.value)" class="bg-[#E0E0E0] text-[#03110D] text-sm font-semibold px-2 py-1 rounded focus:outline-none focus:ring-2 focus:ring-[#A38560] w-full min-w-[4.5rem]">
                                                        @foreach($availableSizes as $size)
                                                            <option value="{{ $size }}" @selected($i->size === $size)>{{ $size }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-4 py-4 text-center text-[#03110D] text-sm">
                                                    <div class="flex items-center justify-center gap-1.5">
                                                        <button onclick="decreaseQty({{ $i->id }})" class="bg-[#E0E0E0] text-[#390517] px-2.5 py-1 rounded hover:bg-gray-300 font-bold">-</button>
                                                        <input type="number" id="qty-{{ $i->id }}" value="{{ $i->qty }}" min="1" class="qty-input border border-[#390517] rounded-lg w-14 h-10 text-center text-[#03110D] focus:outline-none focus:ring-2 focus:ring-[#A38560] font-semibold">
                                                        <button onclick="increaseQty({{ $i->id }})" class="bg-[#E0E0E0] text-[#390517] px-2.5 py-1 rounded hover:bg-gray-300 font-bold">+</button>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-center text-[#03110D] text-sm whitespace-nowrap tabular-nums">Rp&nbsp;{{ number_format($i->product->price, 0, ',', '.') }}</td>
                                                <td class="px-4 py-4 text-center text-[#03110D] text-sm whitespace-nowrap tabular-nums" data-total-{{ $i->id }}>Rp&nbsp;{{ number_format($i->qty * $i->product->price, 0, ',', '.') }}</td>
                                                <td class="px-4 py-4 text-center align-middle">
                                                    <form method="POST" action="{{ route('cart.remove', $i)}}" class="inline-flex justify-center">
                                                        @method('DELETE') @csrf
                                                        <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition-colors text-xs">Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="bg-[#A38560] p-6 rounded-2xl shadow-lg h-fit lg:sticky lg:top-24">
                            <h3 class="font-bold text-lg mb-4 text-center text-[#390517]">Order Summary</h3>
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-[#390517] text-sm">
                                    <span>Sub Total</span>
                                    <span data-subtotal>Rp {{ number_format($cart->total() ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="border-t-2 border-[#390517] pt-3 mb-6">
                                <div class="flex justify-between font-bold text-base text-[#390517]">
                                    <span>Total</span>
                                    <span data-final-total>Rp {{ number_format($cart->total() ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <a href="{{ route('checkout.show') }}" class="block w-full bg-[#390517] text-[#E0E0E0] text-center px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity text-sm">
                                    Checkout Now
                                </a>
                                <a href="{{ url('/') }}" class="block w-full border-2 border-[#390517] text-center px-6 py-3 rounded-lg font-semibold text-[#390517] hover:bg-white transition-colors text-sm">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .qty-input {
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .qty-input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInputs = document.querySelectorAll('.qty-input, input[id*="qty-"]');
        qtyInputs.forEach(input => {
            input.removeAttribute('readonly');
            input.readOnly = false;
            input.disabled = false;
        });

        window.addEventListener('pageshow', function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload(true);
            }
        });
    });

    function getQtyValue(itemId) {
        const qtyInput = document.getElementById('qty-' + itemId);
        if (!qtyInput) {
            return 1;
        }
        const parsed = parseInt(qtyInput.value, 10);
        return Number.isNaN(parsed) ? 1 : parsed;
    }

    function getSelectedSize(itemId) {
        const select = document.querySelector(`[data-size-select="${itemId}"]`);
        return select ? select.value : null;
    }

    function syncSizeSelects(itemId, newSize) {
        document.querySelectorAll(`[data-size-select="${itemId}"]`).forEach(select => {
            if (select.value !== newSize) {
                select.value = newSize;
            }
        });
    }

    function changeSize(itemId, newSize) {
        syncSizeSelects(itemId, newSize);
        updateSingleItemAsync(itemId, getQtyValue(itemId), newSize).catch(console.error);
    }

    function increaseQty(itemId) {
        const qtyInput = document.getElementById('qty-' + itemId);
        if (!qtyInput) return;

        let newQty = parseInt(qtyInput.value) + 1;
        qtyInput.value = newQty;
        qtyInput.defaultValue = newQty;

        document.querySelectorAll(`#qty-${itemId}`).forEach(input => {
            input.value = newQty;
            input.defaultValue = newQty;
        });

        updateCartDisplay();
        updateSingleItemAsync(itemId, newQty, getSelectedSize(itemId)).catch(console.error);
    }

    function decreaseQty(itemId) {
        const qtyInput = document.getElementById('qty-' + itemId);
        if (!qtyInput) return;

        let currentQty = parseInt(qtyInput.value);
        if (currentQty <= 1) return;

        let newQty = currentQty - 1;
        qtyInput.value = newQty;
        qtyInput.defaultValue = newQty;

        document.querySelectorAll(`#qty-${itemId}`).forEach(input => {
            input.value = newQty;
            input.defaultValue = newQty;
        });

        updateCartDisplay();
        updateSingleItemAsync(itemId, newQty, getSelectedSize(itemId)).catch(console.error);
    }

    function updateCartDisplay() {
        let newSubtotal = 0;

        @foreach($cart->items as $i)
            const qty{{ $i->id }} = parseInt(document.getElementById('qty-{{ $i->id }}').value);
            const price{{ $i->id }} = {{ $i->product->price }};
            const total{{ $i->id }} = qty{{ $i->id }} * price{{ $i->id }};
            newSubtotal += total{{ $i->id }};

            const totalElements{{ $i->id }} = document.querySelectorAll('[data-total-{{ $i->id }}]');
            totalElements{{ $i->id }}.forEach(el => {
                el.textContent = 'Rp\u00A0' + total{{ $i->id }}.toLocaleString('id-ID');
            });
        @endforeach

        const subtotalElements = document.querySelectorAll('[data-subtotal]');
        subtotalElements.forEach(el => {
            el.textContent = 'Rp\u00A0' + newSubtotal.toLocaleString('id-ID');
        });

        const finalTotalElements = document.querySelectorAll('[data-final-total]');
        finalTotalElements.forEach(el => {
            el.textContent = 'Rp\u00A0' + newSubtotal.toLocaleString('id-ID');
        });
    }

    function updateSingleItemAsync(itemId, qty, size = null) {
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

            if (size) {
                const sizeInput = document.createElement('input');
                sizeInput.type = 'hidden';
                sizeInput.name = 'size';
                sizeInput.value = size;
                form.appendChild(sizeInput);
            }

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
</script>
@endsection
            
