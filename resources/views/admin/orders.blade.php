<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Pesanan | gayaKu.id</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0D2B23] text-white font-sans min-h-screen flex flex-col items-center">

  <!-- Header -->
  <header class="w-full max-w-6xl bg-[#C8A978] text-[#1a1a1a] rounded-b-2xl px-6 py-4 mt-4 flex justify-between items-center shadow-lg">
    <div class="flex items-center gap-3">
      <button class="bg-[#1A3C2B] text-white px-3 py-2 rounded-lg">&equiv;</button>
      <h1 class="text-xl font-semibold">gayaKu.id</h1>
      <span class="text-sm italic">“Temukan Sesuai Gayamu!”</span>
    </div>
    <nav class="flex gap-4 text-sm">
      <a href="{{ route('admin.products.index') }}" class="hover:underline">Kelola Produk</a>
      <a href="{{ route('admin.orders.index') }}" class="hover:underline font-bold underline">Kelola Pesanan</a>
      <a href="{{ route('home') }}" class="hover:underline">Lihat Toko</a>
    </nav>
  </header>

  <!-- Konten -->
  <main class="w-full max-w-6xl bg-[#18352C] rounded-2xl mt-6 p-6 shadow-xl">

    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold">Daftar Pesanan</h2>

      <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau nomor order..." class="px-4 py-2 rounded-lg bg-[#0F2A20] text-sm text-white placeholder-gray-400 focus:outline-none w-56">
        <button class="bg-[#C8A978] text-[#1a1a1a] px-4 py-2 rounded-lg font-medium hover:bg-[#b48d63]">Cari</button>
      </form>
    </div>

    <table class="w-full text-left border-collapse rounded-lg overflow-hidden">
      <thead class="bg-[#0F2A20] text-gray-300 text-sm uppercase">
        <tr>
          <th class="px-4 py-3">No. Pesanan</th>
          <th class="px-4 py-3">Nama Pembeli</th>
          <th class="px-4 py-3">Tanggal</th>
          <th class="px-4 py-3">Total</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3 text-center">Aksi</th>
        </tr>
      </thead>

      <tbody>
        @forelse ($orders as $order)
        <tr class="border-t border-[#2C5042] hover:bg-[#244637] transition">
          <td class="px-4 py-3 font-mono">{{ $order->order_number }}</td>
          <td class="px-4 py-3">{{ $order->user->name ?? '-' }}</td>
          <td class="px-4 py-3">{{ $order->created_at->format('d M Y, H:i') }}</td>
          <td class="px-4 py-3">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
          <td class="px-4 py-3">
            @php
                $color = match($order->status) {
                    'baru' => 'bg-yellow-600',
                    'diproses' => 'bg-blue-600',
                    'dikirim' => 'bg-purple-600',
                    'selesai' => 'bg-green-600',
                    'batal' => 'bg-red-600',
                    default => 'bg-gray-600',
                };
            @endphp
            <span class="{{ $color }} px-3 py-1 rounded-lg text-xs font-semibold">
              {{ ucfirst($order->status) }}
            </span>
          </td>
          <td class="px-4 py-3 text-center">
            <!-- Tombol ubah status -->
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="inline">
              @csrf
              @method('PATCH')
              <select name="status" class="bg-[#0F2A20] border border-gray-500 text-sm rounded-lg px-2 py-1 text-white"
                      onchange="this.form.submit()">
                <option value="baru" {{ $order->status == 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="batal" {{ $order->status == 'batal' ? 'selected' : '' }}>Batal</option>
              </select>
            </form>

            <!-- Tombol detail -->
            <a href="{{ route('admin.orders.show', $order->id) }}"
              class="border border-[#C8A978] text-[#C8A978] px-3 py-1 rounded-lg text-xs font-medium ml-2 hover:bg-[#C8A978] hover:text-[#1a1a1a] transition">
              Detail
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-6 text-gray-400">Belum ada pesanan</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </main>

  <footer class="mt-6 mb-4 text-sm text-gray-400">
    © 2025 gayaKu.id | Dashboard Admin
  </footer>

</body>
</html>
