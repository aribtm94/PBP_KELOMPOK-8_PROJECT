@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4" style="color: #E0E0E0;">Detail Pesanan #{{ $order->id }}</h1>

{{-- Flash Messages --}}
@if(session('success')) <div class="bg-[#A38560]/20 border border-[#A38560]/30 p-2 mb-3 rounded" style="color: #E0E0E0;">{{ session('success') }}</div> @endif
@if(session('error'))   <div class="bg-red-500/20 border border-red-500/30 p-2 mb-3 rounded" style="color: #E0E0E0;">{{ session('error') }}</div>   @endif

<div class="grid md:grid-cols-2 gap-4 mb-6">
  <div class="border rounded p-3" style="border-color: #E0E0E0;">
    <div style="color: #E0E0E0;"><b>Tanggal:</b> {{ $order->created_at->format('Y-m-d H:i') }}</div>
    <div style="color: #E0E0E0;"><b>User:</b> {{ $order->user->name }} ({{ $order->user->email }})</div>
    <div style="color: #E0E0E0;"><b>Status:</b> <span class="px-2 py-1 rounded bg-[#A38560]/20 border border-[#A38560]/30" style="color: #E0E0E0;">{{ $order->status }}</span></div>
    <div class="mt-2" style="color: #E0E0E0;"><b>Penerima:</b> {{ $order->receiver_name }}</div>
    <div style="color: #E0E0E0;"><b>Alamat:</b> {{ $order->address_text }}</div>
    <div style="color: #E0E0E0;"><b>Telp:</b> {{ $order->phone ?? '-' }}</div>
  </div>

  <div class="border rounded p-3" style="border-color: #E0E0E0;">
    <h2 class="font-semibold mb-2" style="color: #E0E0E0;">Ubah Status</h2>
    <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex gap-2 items-center">
      @csrf @method('PATCH')
      <select name="status" class="border p-2 rounded" style="border-color: #E0E0E0; color: #E0E0E0; background-color: transparent;">
        @foreach(['baru','diproses','dikirim','selesai','batal'] as $s)
          <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
        @endforeach
      </select>
      <button class="border px-3 py-1 rounded" style="color: #E0E0E0; border-color: #E0E0E0;">Simpan</button>
    </form>
  </div>
</div>

<h2 class="font-semibold mb-2" style="color: #E0E0E0;">Item Pesanan</h2>
<table class="w-full border rounded overflow-hidden" style="border-color: #E0E0E0;">
  <tr class="bg-gray-50">
    <th class="p-2 text-left" style="color: #E0E0E0;">Produk</th>
    <th style="color: #E0E0E0;">Ukuran</th>
    <th style="color: #E0E0E0;">Qty</th>
    <th style="color: #E0E0E0;">Harga</th>
    <th style="color: #E0E0E0;">Subtotal</th>
  </tr>
  @foreach($order->items as $i)
    <tr class="border-t" style="border-color: #E0E0E0;">
      <td class="p-2" style="color: #E0E0E0;">{{ $i->product->name }}</td>
      <td class="text-center p-2" style="color: #E0E0E0;">
        <span class="font-semibold">{{ strtoupper($i->size ?? 'N/A') }}</span>
      </td>
      <td class="text-center" style="color: #E0E0E0;">{{ $i->qty }}</td>
      <td class="text-center" style="color: #E0E0E0;">Rp {{ number_format($i->price,0,',','.') }}</td>
      <td class="text-center" style="color: #E0E0E0;">Rp {{ number_format($i->subtotal,0,',','.') }}</td>
    </tr>
  @endforeach
</table>

<div class="mt-3 text-right" style="color: #E0E0E0;">
  <b>Total:</b> Rp {{ number_format($order->total,0,',','.') }}
</div>

<script>
// Handle back button navigation to prevent flash messages
document.addEventListener('DOMContentLoaded', function() {
    // Check for back navigation
    if (window.performance && window.performance.navigation.type === 2) {
        // This is a back navigation, reload to clear flash messages
        window.location.reload(true);
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
</script>

@endsection
