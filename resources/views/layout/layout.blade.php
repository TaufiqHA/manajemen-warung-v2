<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tambahkan Alpine.js untuk fitur interaktif Sidebar -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#eaf4f1] font-sans antialiased text-gray-800 h-screen overflow-hidden">
    
    <!-- Pembungkus keseluruhan layout -->
    <div x-data="{ sidebarOpen: false }" class="flex h-full p-0 md:p-4 relative">
        
        <!-- Panggil Komponen Sidebar -->
        <x-sidebar>
            <a href="{{ url('/dashboard') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->is('dashboard') ? 'bg-[#245D49] text-white font-medium' : 'text-green-100 hover:bg-[#245D49]' }} relative transition-colors">
                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
                @if(request()->is('dashboard'))
                <span class="absolute right-4 w-2 h-2 rounded-full bg-white"></span>
                @endif
            </a>
            <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('categories.*') ? 'bg-[#245D49] text-white font-medium' : 'text-green-100 hover:bg-[#245D49]' }} relative transition-colors">
                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Kategori
                @if(request()->routeIs('categories.*'))
                <span class="absolute right-4 w-2 h-2 rounded-full bg-white"></span>
                @endif
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('products.*') ? 'bg-[#245D49] text-white font-medium' : 'text-green-100 hover:bg-[#245D49]' }} relative transition-colors">
                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Produk
                @if(request()->routeIs('products.*'))
                <span class="absolute right-4 w-2 h-2 rounded-full bg-white"></span>
                @endif
            </a>
            <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('transactions.*') ? 'bg-[#245D49] text-white font-medium' : 'text-green-100 hover:bg-[#245D49]' }} relative transition-colors">
                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Transaksi
                @if(request()->routeIs('transactions.*'))
                <span class="absolute right-4 w-2 h-2 rounded-full bg-white"></span>
                @endif
            </a>
        </x-sidebar>

        <!-- Bagian Konten Utama (Kanan Sidebar) -->
        <div class="flex-1 flex flex-col md:ml-4 bg-[#f8fcfb] md:rounded-3xl overflow-hidden shadow-sm relative w-full">
            
            <!-- Panggil Komponen Headbar -->
            @include('components.headbar')

            <!-- Area Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto px-4 md:px-8 py-4">
                
                <!-- Di sinilah konten dari masing-masing halaman akan disuntikkan -->
                @yield('content')
                
            </main>

            <!-- Panggil Komponen Footer -->
            @include('components.footer')

        </div>
    </div>

</body>
</html>