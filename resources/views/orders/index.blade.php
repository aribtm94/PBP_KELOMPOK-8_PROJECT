@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Pesanan Saya</h1>
<table class="w-full border rounded" style="border-color: #E0E0E0;">
  <tr class="bg-gray-50"><th class="p-2" style="color: #E0E0E0;">No</th><th style="color: #E0E0E0;">Tanggal</th><th style="color: #E0E0E0;">Total</th><th style="color: #E0E0E0;">Status</th><th></th></tr>
  @foreach($orders as $o)
    <tr class="border-t" style="border-color: #E0E0E0;">
      <td class="p-2" style="color: #E0E0E0;">#{{ $o->id }}</td>
      <td style="color: #E0E0E0;">{{ $o->created_at->format('Y-m-d H:i') }}</td>
      <td style="color: #E0E0E0;">Rp {{ number_format($o->total,0,',','.') }}</td>
      <td><span class="px-2 py-1 rounded bg-[#A38560]/20 border border-[#A38560]/30" style="color: #E0E0E0;">{{ $o->status }}</span></td>
      <td><a class="border px-2 py-1 rounded" style="color: #E0E0E0; border-color: #E0E0E0;" href="{{ route('orders.show',$o) }}">Detail</a></td>
    </tr>
  @endforeach
</table>
<div class="mt-3" style="color: #E0E0E0;">{{ $orders->links() }}</div>
@endsection
