@extends('layout.layout')

@section('content')
<div x-data="{ showModalCreate: false, showModalEdit: false, editData: {} }">
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition.duration.500ms class="mb-4 p-4 rounded-2xl bg-green-100 text-green-700 border border-green-200 shadow-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    <!-- Container Utama -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Kategori</h1>
            <p class="text-gray-600 mt-1">Kelola kategori produk untuk warung Anda</p>
        </div>
        <button @click="showModalCreate = true" class="bg-[#2D735B] text-white px-6 py-2.5 rounded-full hover:bg-[#245D49] transition-colors duration-300 font-medium shadow-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kategori
        </button>
    </div>

    <!-- Card Wrapper -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="text-gray-900 border-b border-gray-100">
                            <th class="py-3 px-4 font-bold">Icon</th>
                            <th class="py-3 px-4 font-bold">Nama Kategori</th>
                            <th class="py-3 px-4 font-bold">Deskripsi</th>
                            <th class="py-3 px-4 font-bold">Urutan</th>
                            <th class="py-3 px-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-b border-gray-50 hover:bg-[#f8fcfb] transition-colors duration-300 text-gray-600">
                                <td class="py-4 px-4">
                                    @if($category->icon)
                                        <div class="w-10 h-10 bg-[#eaf4f1] rounded-xl flex items-center justify-center text-[#2D735B]">
                                            <i class="{{ $category->icon }}"></i>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                                            -
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4 font-medium text-gray-800">{{ $category->name }}</td>
                                <td class="py-4 px-4">{{ $category->description ?? '-' }}</td>
                                <td class="py-4 px-4">{{ $category->order }}</td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <button @click="showModalEdit = true; editData = { id: {{ $category->id }}, name: '{{ addslashes($category->name) }}', description: '{{ addslashes($category->description) }}', order: {{ $category->order }}, icon: '{{ addslashes($category->icon) }}' }" class="p-2 text-[#2D735B] hover:bg-[#eaf4f1] rounded-lg transition-colors" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-600">Belum ada data kategori</p>
                                        <p class="text-sm mt-1">Silakan tambahkan kategori baru terlebih dahulu.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div x-show="showModalCreate" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModalCreate" @click="showModalCreate = false" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/50"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showModalCreate" x-transition class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Tambah Kategori Baru</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                                <input type="text" name="name" required class="mt-1 block w-full rounded-full border-gray-300 shadow-sm focus:border-[#2D735B] focus:ring focus:ring-[#2D735B] focus:ring-opacity-50 px-4 py-2 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="description" rows="3" class="mt-1 block w-full rounded-2xl border-gray-300 shadow-sm focus:border-[#2D735B] focus:ring focus:ring-[#2D735B] focus:ring-opacity-50 px-4 py-2 border"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ikon (Opsional)</label>
                                <input type="text" name="icon" class="mt-1 block w-full rounded-full border-gray-300 shadow-sm focus:border-[#2D735B] focus:ring focus:ring-[#2D735B] focus:ring-opacity-50 px-4 py-2 border" placeholder="Contoh: fas fa-hamburger">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Urutan</label>
                                <input type="number" name="order" value="0" class="mt-1 block w-full rounded-full border-gray-300 shadow-sm focus:border-[#2D735B] focus:ring focus:ring-[#2D735B] focus:ring-opacity-50 px-4 py-2 border">
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                        <button type="submit" class="w-full inline-flex justify-center rounded-full border border-transparent shadow-sm px-4 py-2 bg-[#2D735B] text-base font-medium text-white hover:bg-[#245D49] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-300">
                            Simpan
                        </button>
                        <button type="button" @click="showModalCreate = false" class="mt-3 w-full inline-flex justify-center rounded-full border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-300">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div x-show="showModalEdit" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModalEdit" @click="showModalEdit = false" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/50"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showModalEdit" x-transition class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form :action="`/categories/${editData.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Edit Kategori</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                                <input type="text" name="name" x-model="editData.name" required class="mt-1 block w-full rounded-full border-gray-300 shadow-sm focus:border-[#2D735B] focus:ring focus:ring-[#2D735B] focus:ring-opacity-50 px-4 py-2 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="description" x-model="editData.description" rows="3" class="mt-1 block w-full rounded-2xl border-gray-300 shadow-sm focus:border-[#2D735B] focus:ring focus:ring-[#2D735B] focus:ring-opacity-50 px-4 py-2 border"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ikon (Opsional)</label>
                                <input type="text" name="icon" x-model="editData.icon" class="mt-1 block w-full rounded-full border-gray-300 shadow-sm focus:border-[#2D735B] focus:ring focus:ring-[#2D735B] focus:ring-opacity-50 px-4 py-2 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Urutan</label>
                                <input type="number" name="order" x-model="editData.order" class="mt-1 block w-full rounded-full border-gray-300 shadow-sm focus:border-[#2D735B] focus:ring focus:ring-[#2D735B] focus:ring-opacity-50 px-4 py-2 border">
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                        <button type="submit" class="w-full inline-flex justify-center rounded-full border border-transparent shadow-sm px-4 py-2 bg-[#2D735B] text-base font-medium text-white hover:bg-[#245D49] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-300">
                            Simpan Perubahan
                        </button>
                        <button type="button" @click="showModalEdit = false" class="mt-3 w-full inline-flex justify-center rounded-full border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-300">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
