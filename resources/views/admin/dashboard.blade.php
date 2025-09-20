@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Dashboard Admin</h1>

<div class="grid md:grid-cols-4 gap-4 mb-6">
  <div class="border rounded p-4">
    <div class="text-sm text-gray-600">Users</div>
    <div class="text-2xl font-semibold">{{ $stats['users'] }}</div>
  </div>
  <div class="border rounded p-4">
    <div class="text-sm text-gray-600">Produk</div>
    <div class="text-2xl font-semibold">{{ $stats['products'] }}</div>
  </div>
  <div class="border rounded p-4">
    <div class="text-sm text-gray-600">Pesanan</div>
    <div class="text-2xl font-semibold">{{ $stats['orders'] }}</div>
  </div>
  <div class="border rounded p-4">
    <div class="text-sm text-gray-600">Pendapatan (estimasi)</div>
    <div class="text-2xl font-semibold">Rp {{ number_format($stats['revenue'],0,',','.') }}</div>
  </div>
</div>

<h2 class="font-semibold mb-2">Pesanan Terbaru</h2>
<table class="w-full border rounded">
  <tr class="bg-gray-50"><th class="p-2">#</th><th>Tanggal</th><th>User</th><th>Total</th><th>Status</th></tr>
  @forelse($latestOrders as $o)
    <tr class="border-t">
      <td class="p-2">#{{ $o->id }}</td>
      <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
      <td>{{ $o->user->name ?? '-' }}</td>
      <td>Rp {{ number_format($o->total,0,',','.') }}</td>
      <td>{{ $o->status }}</td>
    </tr>
  @empty
    <tr><td colspan="5" class="p-3 text-center text-gray-500">Belum ada pesanan</td></tr>
  @endforelse
</table>
@endsection
