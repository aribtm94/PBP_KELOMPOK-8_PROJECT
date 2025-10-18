@extends('layouts.app')

@section('content')
<div class="space-y-6">

  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-white">Hello, Admin 👋</h1>
    <p class="text-gray-300">Selamat datang kembali di Dashboard Gayaku.id</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="bg-gray-700 text-center text-white p-4 rounded-lg shadow-md">
      <div class="text-3xl font-bold">{{ $stats['new'] ?? 0 }}</div>
      <div class="opacity-70 text-sm mt-1">New Orders</div>
    </div>
    <div class="bg-gray-700 text-center text-white p-4 rounded-lg shadow-md">
      <div class="text-3xl font-bold">{{ $stats['processed'] ?? 0 }}</div>
      <div class="opacity-70 text-sm mt-1">Processed</div>
    </div>
    <div class="bg-gray-700 text-center text-white p-4 rounded-lg shadow-md">
      <div class="text-3xl font-bold">{{ $stats['sent'] ?? 0 }}</div>
      <div class="opacity-70 text-sm mt-1">Sent</div>
    </div>
    <div class="bg-gray-700 text-center text-white p-4 rounded-lg shadow-md">
      <div class="text-3xl font-bold">{{ $stats['finished'] ?? 0 }}</div>
      <div class="opacity-70 text-sm mt-1">Finished</div>
    </div>
    <div class="bg-gray-700 text-center text-white p-4 rounded-lg shadow-md">
      <div class="text-3xl font-bold">{{ $stats['cancelled'] ?? 0 }}</div>
      <div class="opacity-70 text-sm mt-1">Cancelled</div>
    </div>
  </div>

  {{-- Kalender --}}
  <div class="bg-gray-800 rounded-lg p-6 shadow-md mt-8 text-white">
    <h2 class="text-xl font-semibold mb-3">📅 Kalender</h2>
    <div id="calendar" class="text-center"></div>
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
