<!-- Mobile Background Overlay (Gelap transparan) saat menu terbuka -->
<div x-show="sidebarOpen" 
     x-transition.opacity 
     class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 md:hidden" 
     @click="sidebarOpen = false"></div>

<!-- Container Sidebar Utama -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-40 w-64 bg-[#2D735B] text-white flex flex-col justify-between h-full shadow-2xl md:shadow-lg transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 rounded-r-3xl md:rounded-3xl">
    
    <div>
        <!-- Logo & Tombol Close (Mobile) -->
        <div class="flex items-center justify-between px-8 py-8">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2z"/></svg>
                <span class="text-xl font-bold tracking-wide">WarungKu</span>
            </div>
            
            <!-- Tombol Close (Hanya tampil di HP) -->
            <button @click="sidebarOpen = false" class="md:hidden text-green-200 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="flex flex-col mt-4 space-y-2 px-6">
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
        </nav>
    </div>
    
    <!-- Logout Area -->
    <div class="p-6 mb-2">
        <!-- Logout Button (Triggers Modal) -->
        <button type="button" onclick="document.getElementById('logoutModal').classList.remove('hidden')" class="flex items-center justify-center w-full px-4 py-3 bg-white text-[#2D735B] font-semibold rounded-2xl shadow-sm hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Logout
        </button>
    </div>
</aside>

<!-- Logout Modal -->
<div id="logoutModal" class="hidden relative z-50 text-gray-800" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black/40 transition-opacity" onclick="document.getElementById('logoutModal').classList.add('hidden')"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal panel -->
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Konfirmasi Logout</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin keluar dari sistem?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="{{ route('logout') }}" method="POST" class="m-0 p-0 inline-block w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Ya, Logout
                        </button>
                    </form>
                    <button type="button" onclick="document.getElementById('logoutModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
