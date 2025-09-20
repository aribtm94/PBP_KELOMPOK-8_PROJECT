@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Detail Pesanan #{{ $order->id }}</h1>

<div class="grid md:grid-cols-2 gap-4 mb-6">
  <div class="border rounded p-3">
    <div><b>Tanggal:</b> {{ $order->created_at->format('Y-m-d H:i') }}</div>
    <div><b>User:</b> {{ $order->user->name }} ({{ $order->user->email }})</div>
    <div><b>Status:</b> <span class="px-2 py-1 rounded bg-gray-100">{{ $order->status }}</span></div>
    <div class="mt-2"><b>Penerima:</b> {{ $order->receiver_name }}</div>
    <div><b>Alamat:</b> {{ $order->address_text }}</div>
    <div><b>Telp:</b> {{ $order->phone ?? '-' }}</div>
  </div>

  <div class="border rounded p-3">
    <h2 class="font-semibold mb-2">Ubah Status</h2>
    <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex gap-2 items-center">
      @csrf @method('PATCH')
      <select name="status" class="border p-2 rounded">
        @foreach(['baru','diproses','dikirim','selesai','batal'] as $s)
          <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
        @endforeach
      </select>
      <button class="border px-3 py-1 rounded">Simpan</button>
    </form>
  </div>
</div>

<h2 class="font-semibold mb-2">Item Pesanan</h2>
<table class="w-full border rounded">
  <tr class="bg-gray-50">
    <th class="p-2 text-left">Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th>
  </tr>
  @foreach($order->items as $i)
    <tr class="border-t">
      <td class="p-2">{{ $i->product->name }}</td>
      <td class="text-center">{{ $i->qty }}</td>
      <td class="text-center">Rp {{ number_format($i->price,0,',','.') }}</td>
      <td class="text-center">Rp {{ number_format($i->subtotal,0,',','.') }}</td>
    </tr>
  @endforeach
</table>

<div class="mt-3 text-right">
  <b>Total:</b> Rp {{ number_format($order->total,0,',','.') }}
</div>
@endsection
