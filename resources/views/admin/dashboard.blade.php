@extends('layouts.app')

@section('content')
<div class="mt-8">
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="bg-[#390517] p-6 mt-8 rounded-2xl shadow-md space-y-1">
      <h1 class="text-3xl font-bold text-white">Hi Admin 👋</h1>
      <p class="text-gray-300 font-semibold">Welcome back to Gayaku.id.</p>
      <p class="text-gray-300 text-sm">Monitor today’s highlights and keep orders moving.</p>
    </div>

    {{-- Kalender --}}
    <div class="bg-[#390517] rounded-2xl p-6 shadow-md mt-8 text-white">
      <h2 class="text-xl font-semibold mb-3">📅 Kalender</h2>
      <div id="calendar" class="text-center"></div>
    </div>

    {{-- Statistik Pesanan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 sm:col-span-2">
      <div class="bg-[#390517] text-center text-white p-4 rounded-xl shadow-md">
        <h2 class="text-lg font-semibold opacity-80 uppercase tracking-wide">New</h2>
        <div class="text-3xl font-bold mt-2">{{ $stats['new'] ?? 0 }}</div>
      </div>
      <div class="bg-[#390517] text-center text-white p-4 rounded-xl shadow-md">
        <h2 class="text-lg font-semibold opacity-80 uppercase tracking-wide">Processed</h2>
        <div class="text-3xl font-bold mt-2">{{ $stats['processed'] ?? 0 }}</div>
      </div>
      <div class="bg-[#390517] text-center text-white p-4 rounded-xl shadow-md">
        <h2 class="text-lg font-semibold opacity-80 uppercase tracking-wide">Sent</h2>
        <div class="text-3xl font-bold mt-2">{{ $stats['sent'] ?? 0 }}</div>
      </div>
      <div class="bg-[#390517] text-center text-white p-4 rounded-xl shadow-md">
        <h2 class="text-lg font-semibold opacity-80 uppercase tracking-wide">Finished</h2>
        <div class="text-3xl font-bold mt-2">{{ $stats['finished'] ?? 0 }}</div>
      </div>
      <div class="bg-[#390517] text-center text-white p-4 rounded-xl shadow-md">
        <h2 class="text-lg font-semibold opacity-80 uppercase tracking-wide">Cancelled</h2>
        <div class="text-3xl font-bold mt-2">{{ $stats['cancelled'] ?? 0 }}</div>
      </div>
    </div>
    <div class="bg-[#390517] p-6 rounded-2xl shadow-md sm:col-span-2">
      <h1 class="text-2xl font-bold text-white mb-4">New Orders</h1>
      <div class="space-y-3">
        @forelse($newOrders as $order)
          <div class="flex items-center justify-between bg-white/10 px-4 py-3 rounded-xl">
            <div>
              <div class="text-white font-semibold">{{ optional($order->user)->name ?? 'Unknown Customer' }}</div>
              <div class="text-xs text-gray-300">#{{ $order->order_number ?? $order->id }} • {{ ucfirst($order->status) }}</div>
            </div>
            <div class="text-white font-bold whitespace-nowrap">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
          </div>
        @empty
          <p class="text-gray-300 text-sm">No new orders awaiting processing.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>

{{-- Kalender Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const today = new Date();
  const monthNames = [
    "Januari","Februari","Maret","April","Mei","Juni",
    "Juli","Agustus","September","Oktober","November","Desember"
  ];
  let calendarHTML = `
    <div class="font-bold text-lg mb-2">${monthNames[today.getMonth()]} ${today.getFullYear()}</div>
    <table class="w-full text-center">
      <tr class="opacity-70 text-sm">
        <th>Min</th><th>Sen</th><th>Sel</th><th>Rab</th><th>Kam</th><th>Jum</th><th>Sab</th>
      </tr>
      <tr>`;
  
  let firstDay = new Date(today.getFullYear(), today.getMonth(), 1).getDay();
  let totalDays = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();

  for (let i = 0; i < firstDay; i++) {
    calendarHTML += `<td></td>`;
  }

  for (let d = 1; d <= totalDays; d++) {
    let cls = (d === today.getDate()) ? 'bg-yellow-500 text-black font-bold rounded-full' : '';
    calendarHTML += `<td class="p-2 ${cls}">${d}</td>`;
    if ((d + firstDay) % 7 === 0) calendarHTML += `</tr><tr>`;
  }

  calendarHTML += `</tr></table>`;
  calendarEl.innerHTML = calendarHTML;
});
</script>
@endsection
