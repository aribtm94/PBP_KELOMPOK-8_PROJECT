@extends('layouts.app')
@section('content')

<div class="min-h-screen from-slate-50 to-slate-100 py-8 bg-[#FBF2E3] rounded-2xl">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Main Container with rounded corners and shadow -->
        <div class="bg-transparent rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-transparent px-8 py-6">
                <h1 class="text-5xl font-bold text-[#390517]">Your Orders</h1>
            </div>

            <!-- Filter Tabs -->
            <div class="px-8 py-6">
                <div class="flex flex-wrap gap-2 mb-4">
                    <button class="filter-tab active bg-[#390517] text-white px-6 py-2 rounded-full text-sm font-medium transition-all duration-200" data-filter="all">
                        Order
                    </button>
                    <button class="filter-tab bg-transparent border border-[#390517] text-[#390517] hover:bg-[#390517] hover:text-white px-6 py-2 rounded-full text-sm font-medium transition-all duration-200" data-filter="baru">
                        Not Yet Shipped
                    </button>
                    <button class="filter-tab bg-transparent border border-[#390517] text-[#390517] hover:bg-[#390517] hover:text-white px-6 py-2 rounded-full text-sm font-medium transition-all duration-200" data-filter="selesai">
                        Completed
                    </button>
                    <button class="filter-tab bg-transparent border border-[#390517] text-[#390517] hover:bg-[#390517] hover:text-white px-6 py-2 rounded-full text-sm font-medium transition-all duration-200" data-filter="cancelled">
                        Cancelled Orders
                    </button>
                </div>
                
                <!-- Time Filter -->
                <div class="flex justify-end">
                    <select class="bg-transparent border border-[#390517] text-[#390517] rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[#390517] focus:border-transparent">
                        <option value="1year">Past 1 Years</option>
                        <option value="6months">Past 6 Months</option>
                        <option value="3months">Past 3 Months</option>
                        <option value="1month">Past 1 Month</option>
                    </select>
                </div>
            </div>

            <!-- Orders Content -->
            <div class="px-8 py-6">
                @if($orders->isEmpty())
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 mx-auto mb-6 bg-[#390517]/20 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-[#390517]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#390517] mb-2">No Orders Yet</h3>
                        <p class="text-[#390517] opacity-70 mb-6">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                        <a href="{{ url('/') }}" class="bg-[#390517] text-white px-8 py-3 rounded-lg font-medium hover:bg-[#2a0411] transition-colors">
                            Start Shopping
                        </a>
                    </div>
                @else
                    <!-- Orders List -->
                    <div class="space-y-4">
                        @foreach($orders as $o)
                            <div class="order-card bg-transparent border border-[#390517]/30 rounded-xl p-6 hover:border-[#390517] transition-all duration-200" data-status="{{ $o->status }}">
                                <!-- Order Header -->
                                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-4">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4 lg:mb-0">
                                        <div>
                                            <div class="text-sm text-[#390517] opacity-70 mb-1">Order Date :</div>
                                            <div class="font-medium text-[#390517]">{{ $o->created_at->format('M d, Y') }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-[#390517] opacity-70 mb-1">Total Amount :</div>
                                            <div class="font-semibold text-[#390517]">Rp {{ number_format($o->total,0,',','.') }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-[#390517] opacity-70 mb-1">Ship To :</div>
                                            <div class="font-medium text-[#390517]">{{ $o->address_text ?? 'Address not specified' }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                                        <div class="text-sm text-[#390517] opacity-70 text-right">Order : #{{ str_pad($o->id, 11, '0', STR_PAD_LEFT) }}</div>
                                        <div class="flex gap-2">
                                            <button class="bg-transparent border border-[#390517] hover:bg-[#390517] hover:text-white text-[#390517] px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                View Invoice
                                            </button>
                                            <a href="{{ route('orders.show', $o) }}" class="bg-[#390517] hover:bg-[#2a0411] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                View Order
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rating Banner (if completed) -->
                                @if($o->status == 'selesai')
                                <div class="bg-yellow-400/20 border border-yellow-400 rounded-lg p-3 mb-4 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 bg-yellow-400 rounded flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-[#390517]">Please rate your experience</span>
                                    </div>
                                    <button class="text-[#390517] opacity-40 hover:opacity-70">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                @endif

                                <!-- Order Items -->
                                @foreach($o->items as $item)
                                <div class="bg-transparent border border-[#390517]/20 rounded-lg p-4 mb-3">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-[#390517] mb-2">{{ $item->product->name }}</h4>
                                            <p class="text-sm text-[#390517] opacity-70 mb-2">Size: {{ strtoupper($item->size ?? 'N/A') }} | Qty: {{ $item->qty }}</p>
                                            @if($o->status == 'selesai')
                                            <p class="text-sm text-[#390517] opacity-70 mb-3">Return or Replace items : Eligible through {{ $o->created_at->addDays(30)->format('M d, Y') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($o->status == 'selesai')
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        <button class="flex items-center gap-2 bg-transparent border border-[#390517] text-[#390517] hover:bg-[#390517] hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Buy it again
                                        </button>
                                        <button class="flex items-center gap-2 bg-transparent border border-[#390517] text-[#390517] hover:bg-[#390517] hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Product
                                        </button>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8 border-t border-[#390517]/30 pt-6">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .filter-tab.active {
        background-color: #390517 !important;
        color: white !important;
    }
    
    .order-card {
        transition: all 0.2s ease;
    }
    
    .order-card:hover {
        transform: translateY(-1px);
    }
    
    .fade-out {
        opacity: 0.3;
        pointer-events: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const orderCards = document.querySelectorAll('.order-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active tab
            filterTabs.forEach(t => {
                t.classList.remove('active', 'bg-[#390517]', 'text-white');
                t.classList.add('bg-transparent', 'border', 'border-[#390517]', 'text-[#390517]');
            });
            
            this.classList.add('active', 'bg-[#390517]', 'text-white');
            this.classList.remove('bg-transparent', 'border', 'border-[#390517]', 'text-[#390517]');
            
            const filter = this.dataset.filter;
            
            // Filter orders
            orderCards.forEach(card => {
                const status = card.dataset.status;
                
                if (filter === 'all' || status === filter) {
                    card.style.display = 'block';
                    card.classList.remove('fade-out');
                } else {
                    card.classList.add('fade-out');
                    setTimeout(() => {
                        if (card.classList.contains('fade-out')) {
                            card.style.display = 'none';
                        }
                    }, 200);
                }
            });
        });
    });
});
</script>

@endsection
