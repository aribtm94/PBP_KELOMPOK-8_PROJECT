@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-3">Pesanan Saya</h1>
<table class="w-full border rounded">
  <tr class="bg-gray-50"><th class="p-2">No</th><th>Tanggal</th><th>Total</th><th>Status</th><th></th></tr>
  @foreach($orders as $o)
    <tr class="border-t">
      <td class="p-2">#{{ $o->id }}</td>
      <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
      <td>Rp {{ number_format($o->total,0,',','.') }}</td>
      <td><span class="px-2 py-1 rounded bg-gray-100">{{ $o->status }}</span></td>
      <td><a class="border px-2 py-1 rounded" href="{{ route('orders.show',$o) }}">Detail</a></td>
    </tr>
  @endforeach
</table>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
