<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tambahkan Alpine.js untuk fitur interaktif Sidebar -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#eaf4f1] font-sans antialiased text-gray-800 h-screen overflow-hidden">
    
    <div x-data="{ sidebarOpen: false }" class="flex h-full p-0 md:p-4 relative">
        
        <!-- Panggil Komponen Sidebar dengan Menu Khusus Owner -->
        <x-sidebar>
            <a href="{{ url('/owner/dashboard') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->is('owner/dashboard') ? 'bg-[#245D49] text-white font-medium' : 'text-green-100 hover:bg-[#245D49]' }} relative transition-colors">
                <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
                @if(request()->is('owner/dashboard'))
                <span class="absolute right-4 w-2 h-2 rounded-full bg-white"></span>
                @endif
            </a>
            <!-- Tambahkan menu-menu lain sesuai fitur Owner -->
        </x-sidebar>

        <!-- Area Main Content -->
        <div class="flex-1 flex flex-col md:ml-4 bg-[#f8fcfb] md:rounded-3xl overflow-hidden shadow-sm relative w-full">
            @include('components.headbar')

            <main class="flex-1 overflow-x-hidden overflow-y-auto px-4 md:px-8 py-4">
                @yield('content')
            </main>

            @include('components.footer')
        </div>
    </div>
</body>
</html>
