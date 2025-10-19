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
    <div class="sm:col-span-2 space-y-4">
      <div class="bg-[#390517] text-white p-4 rounded-xl shadow-md flex flex-wrap items-center justify-between gap-3">
        <div>
          <h2 class="text-lg font-semibold">Order Snapshot</h2>
          <p class="text-sm text-white/80" data-status-range-label>{{ $defaultRangeLabel ?? 'Semua tanggal' }}</p>
          <p class="hidden text-xs text-red-200 mt-2" data-status-error></p>
        </div>
        <button type="button" class="hidden text-sm font-semibold text-[#390517] bg-white/90 hover:bg-white px-3 py-1 rounded-full transition-colors" data-reset-stats>Reset</button>
      </div>

      <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
        <div class="bg-[#390517] text-center text-white p-4 rounded-xl shadow-md">
          <h2 class="text-lg font-semibold opacity-80 uppercase tracking-wide">New</h2>
          <div class="text-3xl font-bold mt-2" data-status-value="new">{{ $orderStatusStats['new'] ?? 0 }}</div>
        </div>
        <div class="bg-[#390517] text-center text-white p-4 rounded-xl shadow-md">
          <h2 class="text-lg font-semibold opacity-80 uppercase tracking-wide">Processed</h2>
          <div class="text-3xl font-bold mt-2" data-status-value="processed">{{ $orderStatusStats['processed'] ?? 0 }}</div>
        </div>
        <div class="bg-[#390517] text-center text-white p-4 rounded-xl shadow-md">
          <h2 class="text-lg font-semibold opacity-80 uppercase tracking-wide">Sent</h2>
          <div class="text-3xl font-bold mt-2" data-status-value="sent">{{ $orderStatusStats['sent'] ?? 0 }}</div>
        </div>
        <div class="bg-[#390517] text-center text-white p-4 rounded-xl shadow-md">
          <h2 class="text-lg font-semibold opacity-80 uppercase tracking-wide">Finished</h2>
          <div class="text-3xl font-bold mt-2" data-status-value="finished">{{ $orderStatusStats['finished'] ?? 0 }}</div>
        </div>
        <div class="bg-[#390517] text-center text-white p-4 rounded-xl shadow-md">
          <h2 class="text-lg font-semibold opacity-80 uppercase tracking-wide">Cancelled</h2>
          <div class="text-3xl font-bold mt-2" data-status-value="cancelled">{{ $orderStatusStats['cancelled'] ?? 0 }}</div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 bg-[#390517] p-6 rounded-2xl shadow-md sm:col-span-2">
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
  if (!calendarEl) return;

  const statusKeys = ['new', 'processed', 'sent', 'finished', 'cancelled'];
  const statusValueEls = statusKeys.reduce((acc, key) => {
    acc[key] = document.querySelector(`[data-status-value="${key}"]`);
    return acc;
  }, {});

  const statusRangeLabel = document.querySelector('[data-status-range-label]');
  const resetButton = document.querySelector('[data-reset-stats]');
  const errorLabel = document.querySelector('[data-status-error]');

  const defaultStats = @json($orderStatusStats ?? []);
  const defaultLabel = @json($defaultRangeLabel ?? 'Semua tanggal');
  const statsUrlTemplate = @json(route('admin.dashboard.stats', ['date' => '__DATE__']));
  const todayIso = @json($todayDate ?? now()->toDateString());

  const monthNames = [
    'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'
  ];

  const [yearString, monthString] = todayIso.split('-');
  const now = new Date();
  const parsedYear = parseInt(yearString, 10);
  const parsedMonth = parseInt(monthString, 10);
  const displayYear = Number.isNaN(parsedYear) ? now.getFullYear() : parsedYear;
  const displayMonth = Number.isNaN(parsedMonth) ? now.getMonth() : Math.max(0, parsedMonth - 1);
  const fallbackToday = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;
  const todayDate = Number.isNaN(parsedYear) || Number.isNaN(parsedMonth) ? fallbackToday : todayIso;

  let selectedDate = null;
  let currentRequestId = 0;

  const baseButtonClasses = 'calendar-day w-10 h-10 mx-auto flex items-center justify-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-white/70';

  function formatDate(year, monthIndex, day) {
    const month = String(monthIndex + 1).padStart(2, '0');
    const date = String(day).padStart(2, '0');
    return `${year}-${month}-${date}`;
  }

  function renderCalendar() {
    const firstDay = new Date(displayYear, displayMonth, 1).getDay();
    const totalDays = new Date(displayYear, displayMonth + 1, 0).getDate();

    let html = `<div class="font-bold text-lg mb-3">${monthNames[displayMonth]} ${displayYear}</div>`;
    html += '<table class="w-full text-center text-white">';
    html += '<thead><tr class="opacity-70 text-sm"><th>Min</th><th>Sen</th><th>Sel</th><th>Rab</th><th>Kam</th><th>Jum</th><th>Sab</th></tr></thead>';
    html += '<tbody><tr>';

    let column = 0;
    for (let i = 0; i < firstDay; i++) {
      html += '<td class="p-1"></td>';
      column++;
    }

    for (let day = 1; day <= totalDays; day++) {
      if (column === 7) {
        html += '</tr><tr>';
        column = 0;
      }

      const dateStr = formatDate(displayYear, displayMonth, day);
      html += `<td class="p-1"><button type="button" data-date="${dateStr}" class="${baseButtonClasses}">${day}</button></td>`;
      column++;
    }

    if (column !== 0 && column < 7) {
      for (; column < 7; column++) {
        html += '<td class="p-1"></td>';
      }
    }

    html += '</tr></tbody></table>';
    calendarEl.innerHTML = html;

    applyCalendarStyles();
  }

  function applyCalendarStyles() {
    const buttons = calendarEl.querySelectorAll('button[data-date]');
    buttons.forEach((btn) => {
      const date = btn.dataset.date;
      btn.className = `${baseButtonClasses} text-white/80 hover:bg-white/10`;

      if (date === todayDate && (!selectedDate || selectedDate !== date)) {
        btn.classList.remove('text-white/80');
        btn.classList.add('border', 'border-white/60', 'text-white');
      }

      if (selectedDate && date === selectedDate) {
        btn.classList.remove('text-white/80', 'hover:bg-white/10', 'border', 'border-white/60', 'text-white');
        btn.classList.add('bg-white', 'text-[#390517]', 'font-semibold');
      }
    });
  }

  function updateStatCards(data) {
    statusKeys.forEach((key) => {
      const target = statusValueEls[key];
      if (!target) return;
      const value = data && Object.prototype.hasOwnProperty.call(data, key) ? data[key] : 0;
      target.textContent = value;
    });
  }

  function setRangeLabel(text) {
    if (statusRangeLabel) {
      statusRangeLabel.textContent = text;
    }
  }

  function toggleReset(visible) {
    if (!resetButton) return;
    resetButton.classList.toggle('hidden', !visible);
  }

  function showError(message) {
    if (!errorLabel) return;
    errorLabel.textContent = message;
    errorLabel.classList.remove('hidden');
  }

  function clearError() {
    if (!errorLabel) return;
    errorLabel.textContent = '';
    errorLabel.classList.add('hidden');
  }

  function loadStats(dateStr) {
    const previousDate = selectedDate;
    const previousLabel = statusRangeLabel ? statusRangeLabel.textContent : defaultLabel;

    const requestId = ++currentRequestId;

    selectedDate = dateStr;
    applyCalendarStyles();
    clearError();
    setRangeLabel('Sedang memuat...');

    const url = statsUrlTemplate.replace('__DATE__', dateStr);

    return fetch(url, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Request failed');
        }
        return response.json();
      })
      .then((payload) => {
        if (requestId !== currentRequestId) {
          return;
        }

        const stats = payload && payload.stats ? payload.stats : {};
        updateStatCards(stats);

        selectedDate = payload && payload.date ? payload.date : dateStr;
        applyCalendarStyles();

        setRangeLabel(payload && payload.label ? payload.label : dateStr);
        toggleReset(true);
      })
      .catch(() => {
        if (requestId !== currentRequestId) {
          return;
        }

        selectedDate = previousDate;
        applyCalendarStyles();
        setRangeLabel(previousLabel);
        toggleReset(Boolean(previousDate));
        showError('Tidak dapat memuat statistik untuk tanggal yang dipilih.');
      });
  }

  function handleReset() {
    currentRequestId++;
    selectedDate = null;
    updateStatCards(defaultStats);
    setRangeLabel(defaultLabel);
    clearError();
    toggleReset(false);
    applyCalendarStyles();
  }

  function handleCalendarClick(event) {
    const button = event.target.closest('button[data-date]');
    if (!button) return;

    const dateStr = button.dataset.date;
    if (!dateStr || dateStr === selectedDate) {
      return;
    }

    loadStats(dateStr);
  }

  renderCalendar();
  updateStatCards(defaultStats);
  setRangeLabel(defaultLabel);
  clearError();
  toggleReset(false);

  calendarEl.addEventListener('click', handleCalendarClick);
  if (resetButton) {
    resetButton.addEventListener('click', handleReset);
  }
});
</script>
@endsection
