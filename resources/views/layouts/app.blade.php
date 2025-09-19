<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-white text-gray-800">
  <nav class="border-b bg-white">
    <div class="max-w-6xl mx-auto px-4 py-3 flex gap-4 items-center">
      <a href="{{ route('home') }}" class="font-bold">{{ config('app.name') }}</a>
      <a href="{{ route('home') }}" class="hover:underline">Produk</a>
      <a href="{{ route('cart.index') }}" class="hover:underline">
        Keranjang ({{ auth()->user()?->cart?->items()->sum('qty') ?? 0 }})
      </a>
      <div class="ml-auto flex gap-3 items-center">
        @auth
          <a href="{{ route('orders.index') }}" class="hover:underline">Pesanan</a>
          @can('admin')
            <a href="{{ route('admin.products.index') }}" class="hover:underline">Dashboard Admin</a>
          @endcan
          <form method="POST" action="{{ route('logout') }}">@csrf
            <button class="px-3 py-1 border rounded">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="px-3 py-1 border rounded">Login</a>
        @endauth
      </div>
    </div>
  </nav>

  <main class="max-w-6xl mx-auto px-4 py-6 w-full flex-1">
    @if(session('success')) <div class="mb-3 p-3 bg-green-100 rounded">{{ session('success') }}</div> @endif
    @if(session('error'))   <div class="mb-3 p-3 bg-red-100 rounded">{{ session('error') }}</div>   @endif
    @yield('content')
  </main>

  <footer class="border-t">
    <div class="max-w-6xl mx-auto px-4 py-4 text-sm text-center">
      UMKM Butik • WA/IG: @umkmbutik • Info singkat UMKM
    </div>
  </footer>
</body>
</html>
