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
            {{ $slot }}
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
