@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mx-auto p-6 text-white" style="background-color:#16302B; min-height:100vh;">
    <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

    <div class="bg-[#2b4b47] p-4 rounded-2xl mb-6 shadow-md">
        <h2 class="text-xl font-semibold">Hello, {{ auth()->user()->name }} 👋</h2>
        <p class="text-sm text-gray-300">Selamat datang di Dashboard GayaKu.id</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-[#2b4b47] p-4 rounded-xl text-center">
            <p class="text-lg font-semibold">New</p>
            <h3 class="text-2xl font-bold">{{ $stats['new'] }}</h3>
        </div>
        <div class="bg-[#2b4b47] p-4 rounded-xl text-center">
            <p class="text-lg font-semibold">Processed</p>
            <h3 class="text-2xl font-bold">{{ $stats['processed'] }}</h3>
        </div>
        <div class="bg-[#2b4b47] p-4 rounded-xl text-center">
            <p class="text-lg font-semibold">Sent</p>
            <h3 class="text-2xl font-bold">{{ $stats['sent'] }}</h3>
        </div>
        <div class="bg-[#2b4b47] p-4 rounded-xl text-center">
            <p class="text-lg font-semibold">Finished</p>
            <h3 class="text-2xl font-bold">{{ $stats['finished'] }}</h3>
        </div>
        <div class="bg-[#2b4b47] p-4 rounded-xl text-center">
            <p class="text-lg font-semibold">Cancelled</p>
            <h3 class="text-2xl font-bold">{{ $stats['cancelled'] }}</h3>
        </div>
    </div>

    <!-- Kalender & Pesanan Terbaru -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kalender -->
        <div class="bg-[#2b4b47] p-4 rounded-2xl">
            <h3 class="text-lg font-semibold mb-2">Kalender</h3>
            <iframe src="https://calendar.google.com/calendar/embed?height=250&wkst=1&bgcolor=%232b4b47&ctz=Asia%2FJakarta" style="border:0; width:100%; height:250px;" frameborder="0"></iframe>
        </div>

        <div class="bg-[#2b4b47] p-4 rounded-2xl md:col-span-2">
            <h3 class="text-lg font-semibold mb-4">Pesanan Terbaru</h3>
            <table class="w-full text-sm">
                <thead class="border-b border-gray-600">
                    <tr>
                        <th class="text-left py-2">Order</th>
                        <th class="text-left py-2">User</th>
                        <th class="text-left py-2">Status</th>
                        <th class="text-right py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestOrders as $order)
                    <tr class="border-b border-gray-700 hover:bg-[#1f3a36]">
                        <td class="py-2">{{ $order->order_number }}</td>
                        <td class="py-2">{{ $order->user->name ?? '-' }}</td>
                        <td class="py-2 capitalize">{{ $order->status }}</td>
                        <td class="py-2 text-right">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-3 text-center text-gray-400">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
