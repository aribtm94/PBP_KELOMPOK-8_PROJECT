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
                    <button class="filter-tab bg-transparent border border-[#390517] text-[#390517] hover:bg-[#390517] hover:text-white px-6 py-2 rounded-full text-sm font-medium transition-all duration-200" data-filter="batal">
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
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-8 mb-4 lg:mb-0">
                                        <div class="min-w-[220px]">
                                            <div class="text-sm text-[#390517] opacity-70 mb-1">Order Date :</div>
                                            <div class="font-medium text-[#390517]">{{ $o->created_at->format('M d, Y') }}</div>
                                        </div>

                                        <div class="min-w-[220px]">
                                            <div class="text-sm text-[#390517] opacity-70 mb-1">Total Amount :</div>
                                            <div class="font-semibold text-[#390517]">Rp {{ number_format($o->total,0,',','.') }}</div>
                                        </div>

                                        <div class="flex-1">
                                            <div class="text-sm text-[#390517] opacity-70 mb-1">Ship To :</div>
                                            <div class="font-medium text-[#390517]">{{ $o->receiver_address ?? 'Address not specified' }}</div>
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

                                <!-- Rating Banner removed -->

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
                                    
                                    {{-- Buy it again removed per request --}}
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

    // Handle back button navigation to prevent flash messages
    window.addEventListener('pageshow', function(event) {
        // Check if page was loaded from cache (back button)
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            // Refresh the page to clear any flash messages
            window.location.reload(true);
        }
    });

    // Alternative method: Clear flash messages on back navigation
    if (window.performance && window.performance.navigation.type === 2) {
        // This is a back navigation, reload to clear flash messages
        window.location.reload(true);
    }
});
</script>

@endsection
