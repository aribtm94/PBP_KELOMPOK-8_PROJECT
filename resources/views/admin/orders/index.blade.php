@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
  <h1 class="text-2xl font-bold text-white">Kelola Pesanan</h1>
  <a href="{{ route('admin.dashboard') }}" 
     class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
    ← Dashboard
  </a>
</div>
{{-- Dashboard widgets removed from orders management; stats shown only in dashboard page --}}

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
          @php
            $statusClasses = [
              'baru' => 'bg-yellow-500/20 text-yellow-300',
              'diproses' => 'bg-blue-500/20 text-blue-300',
              'dikirim' => 'bg-indigo-500/20 text-indigo-300',
              'selesai' => 'bg-green-500/20 text-green-300',
              'batal' => 'bg-red-500/20 text-red-300',
            ];
            $statusClass = $statusClasses[$o->status] ?? 'bg-gray-500/20 text-gray-300';
          @endphp
          <span class="px-2 py-1 rounded text-xs font-semibold inline-block {{ $statusClass }}">
            {{ ucfirst($o->status) }}
          </span>
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
