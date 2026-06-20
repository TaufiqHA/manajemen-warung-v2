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
        @include('components.sidebar')

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