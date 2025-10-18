@extends('layouts.app')

@section('content')
<div class="space-y-6 animate-fade-in">
    <h1 class="text-2xl font-bold text-[#E0E0E0] mb-4 border-b border-[#A38560]/30 pb-2">
        Detail Pesanan <span class="text-[#A38560]">#{{ $order->id }}</span>
    </h1>

    <!-- Informasi Pesanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informasi Pembeli -->
        <div class="bg-[#1F3A34] border border-[#A38560]/40 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all">
            <h2 class="text-lg font-semibold text-[#A38560] mb-3">Informasi Pesanan</h2>
            <div class="space-y-2 text-sm text-[#E0E0E0]">
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>User:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
                <p>
                    <strong>Status:</strong> 
                    <span class="px-2 py-1 rounded-lg text-xs font-semibold 
                        @if($order->status === 'baru') bg-yellow-500/20 text-yellow-400 
                        @elseif($order->status === 'diproses') bg-blue-500/20 text-blue-400 
                        @elseif($order->status === 'dikirim') bg-indigo-500/20 text-indigo-400 
                        @elseif($order->status === 'selesai') bg-green-500/20 text-green-400 
                        @elseif($order->status === 'batal') bg-red-500/20 text-red-400 
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p><strong>Penerima:</strong> {{ $order->receiver_name }}</p>
                <p><strong>Alamat:</strong> {{ $order->receiver_address ?? '-' }}</p>
                <p><strong>Telp:</strong> {{ $order->receiver_phone ?? '-' }}</p>
            </div>
        </div>

        <!-- Ubah Status -->
        <div class="bg-[#1F3A34] border border-[#A38560]/40 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all">
            <h2 class="text-lg font-semibold text-[#A38560] mb-3">Ubah Status</h2>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <select name="status" class="w-full bg-[#16302B] text-white border border-[#A38560]/50 rounded-lg p-2 focus:ring-2 focus:ring-[#A38560]">
                    @foreach(['baru','diproses','dikirim','selesai','batal'] as $s)
                        <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-[#A38560] text-[#390517] font-semibold py-2 rounded-lg hover:bg-[#8B7355] transition-colors">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <!-- Item Pesanan -->
    <div class="bg-[#1F3A34] border border-[#A38560]/40 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all">
        <h2 class="text-lg font-semibold text-[#A38560] mb-3">Item Pesanan</h2>
        <div class="overflow-x-auto rounded-xl">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#A38560]/20 text-[#E0E0E0] text-left">
                        <th class="p-3">Produk</th>
                        <th class="p-3">Ukuran</th>
                        <th class="p-3">Qty</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr class="border-b border-[#A38560]/20 text-[#E0E0E0] hover:bg-[#A38560]/10 transition-all">
                        <td class="p-3">{{ $item->product->name }}</td>
                        <td class="p-3">{{ $item->size ?? '-' }}</td>
                        <td class="p-3">{{ $item->qty }}</td>
                        <td class="p-3">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="p-3">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-right text-[#A38560] font-semibold mt-4">
            Total: Rp {{ number_format($order->total, 0, ',', '.') }}
        </div>
    </div>
</div>
@endsection
