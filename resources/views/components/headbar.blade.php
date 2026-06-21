<header class="flex items-center justify-between px-4 md:px-8 py-4 md:py-6 bg-white md:bg-transparent shadow-sm md:shadow-none z-10">
    
    <div class="flex items-center flex-1">
        <!-- Tombol Hamburger (Hanya tampil di HP) -->
        <button @click="sidebarOpen = true" class="mr-4 md:hidden text-gray-600 focus:outline-none hover:text-[#2D735B]">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
        </button>

        <!-- Search Bar (Sembunyikan di layar sangat kecil/HP, munculkan di tablet ke atas) -->
        <div class="relative w-full max-w-sm hidden sm:block">
            <input type="text" placeholder="Search..." class="w-full py-2.5 md:py-3 pl-6 pr-12 rounded-full border-none shadow-sm md:shadow-sm focus:ring-2 focus:ring-[#2D735B] outline-none bg-gray-100 md:bg-white text-gray-700 text-sm md:text-base">
            <div class="absolute right-4 top-2.5 md:top-3 text-gray-400">
                <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- Actions Pill -->
    <div class="flex items-center bg-[#2D735B] rounded-full p-1 md:p-1.5 space-x-2 md:space-x-6 shadow ml-2">
        <!-- Upload button placeholder -->
        {{-- <button class="hidden md:flex pl-4 pr-3 text-white text-sm items-center border border-dashed border-white rounded-full py-1.5 ml-2 hover:bg-[#245D49] transition">
            <span class="mr-1">+</span> Upload
        </button> --}}
        <!-- Notification -->
        <button class="pl-3 text-white hover:text-gray-200 transition">
            <svg class="w-5 h-5 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        </button>
        <!-- Profile Avatar -->
        @php
            // Mengambil nama user yang login, fallback ke 'User Name' jika gagal
            $name = auth()->check() ? auth()->user()->name : 'User Name';
            $words = explode(' ', trim($name));
            $initials = '';
            
            // Ambil huruf pertama kata ke-1
            if (isset($words[0]) && strlen($words[0]) > 0) {
                $initials .= strtoupper(substr($words[0], 0, 1));
            }
            // Ambil huruf pertama kata ke-2
            if (isset($words[1]) && strlen($words[1]) > 0) {
                $initials .= strtoupper(substr($words[1], 0, 1));
            }
        @endphp

        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-white flex items-center justify-center text-[#2D735B] font-bold text-xs md:text-sm mr-0.5 md:mr-1">
            {{ $initials ?: 'YN' }}
        </div>
    </div>
</header>
