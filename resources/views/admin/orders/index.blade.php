@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
  <h1 class="text-2xl font-bold text-white">Kelola Pesanan</h1>
  <a href="{{ route('admin.dashboard') }}" 
     class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
    ← Dashboard
  </a>
</div>

{{-- Statistik Ringkas --}}
<div class="grid grid-cols-5 gap-4 mb-6">
  <div class="bg-gray-800 text-center text-white p-4 rounded-lg shadow-md">
    <div class="text-3xl font-bold">{{ $stats['new'] ?? 0 }}</div>
    <div class="text-sm opacity-80">New Orders</div>
  </div>
  <div class="bg-gray-800 text-center text-white p-4 rounded-lg shadow-md">
    <div class="text-3xl font-bold">{{ $stats['processed'] ?? 0 }}</div>
    <div class="text-sm opacity-80">Processed</div>
  </div>
  <div class="bg-gray-800 text-center text-white p-4 rounded-lg shadow-md">
    <div class="text-3xl font-bold">{{ $stats['sent'] ?? 0 }}</div>
    <div class="text-sm opacity-80">Sent</div>
  </div>
  <div class="bg-gray-800 text-center text-white p-4 rounded-lg shadow-md">
    <div class="text-3xl font-bold">{{ $stats['finished'] ?? 0 }}</div>
    <div class="text-sm opacity-80">Finished</div>
  </div>
  <div class="bg-gray-800 text-center text-white p-4 rounded-lg shadow-md">
    <div class="text-3xl font-bold">{{ $stats['cancelled'] ?? 0 }}</div>
    <div class="text-sm opacity-80">Cancelled</div>
  </div>
</div>

{{-- Tabel Pesanan --}}
<h2 class="text-xl font-semibold mb-3 text-white">Daftar Pesanan</h2>

<div class="overflow-x-auto">
  <table class="w-full border border-gray-600 text-white rounded-lg overflow-hidden">
    <thead class="bg-gray-700">
      <tr>
        <th class="p-3 text-left">No</th>
        <th class="text-left">User</th>
        <th class="text-left">Items</th>
        <th class="text-left">Tanggal</th>
        <th class="text-left">Total</th>
        <th class="text-left">Status</th>
        <th class="text-left">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $o)
      <tr class="border-t border-gray-700 hover:bg-gray-800 transition">
        <td class="p-3">#{{ $o->id }}</td>
        <td>{{ $o->user->name ?? 'N/A' }} ({{ $o->user->email ?? '-' }})</td>
        <td>{{ $o->items->count() }} item(s)</td>
        <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
        <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
        <td>
          @php $isFinal = in_array($o->status, ['batal','selesai']); @endphp
          <form method="POST" action="{{ route('admin.orders.status', $o) }}" class="flex items-center gap-2">
            @csrf @method('PATCH')
            <select name="status" 
                    {{ $isFinal ? 'disabled' : '' }}
                    class="bg-gray-900 border border-gray-600 text-white rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-gray-400">
              @foreach(['baru','diproses','dikirim','selesai','batal'] as $s)
                <option value="{{ $s }}" @selected($o->status === $s)>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
            <button type="submit" {{ $isFinal ? 'disabled' : '' }} class="bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded text-sm {{ $isFinal ? 'opacity-50 cursor-not-allowed' : '' }}">Ubah</button>
          </form>
        </td>
        <td>
          <a href="{{ route('admin.orders.show', $o) }}" 
             class="bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded text-sm inline-block">
            Detail
          </a>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="text-center py-4 text-gray-400">Tidak ada pesanan ditemukan.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
