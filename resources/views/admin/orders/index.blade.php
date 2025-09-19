@extends('layouts.app')
@section('content')
<h1 class="text-xl font-bold mb-3">Admin • Pesanan</h1>
<table class="w-full border rounded">
  <tr class="bg-gray-50"><th>No</th><th>User</th><th>Tanggal</th><th>Total</th><th>Status</th><th></th></tr>
  @foreach($orders as $o)
  <tr class="border-t">
    <td class="p-2">#{{ $o->id }}</td>
    <td>{{ $o->user->name }} ({{ $o->user->email }})</td>
    <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
    <td>Rp {{ number_format($o->total,0,',','.') }}</td>
    <td>
      <form method="POST" action="{{ route('admin.orders.status',$o) }}" class="flex gap-2">@csrf @method('PATCH')
        <select name="status" class="border p-1 rounded">
          @foreach(['baru','diproses','dikirim','selesai','batal'] as $s)
            <option value="{{ $s }}" @selected($o->status===$s)>{{ $s }}</option>
          @endforeach
        </select>
        <button class="border px-2 rounded">Ubah</button>
      </form>
    </td>
    <td><a class="border px-2 py-1 rounded" href="{{ route('admin.orders.show',$o) }}">Detail</a></td>
  </tr>
  @endforeach
</table>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
