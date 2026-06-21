@extends('layout.layout')

@section('content')
<div x-data="{ showModalCreate: false, showModalEdit: false, editData: {} }">
    @include('components.successAlert')
    
    <x-page-header title="Daftar Kategori" subtitle="Kelola kategori produk untuk warung Anda">
        <x-button @click="showModalCreate = true" color="primary" size="lg">
            Tambah Kategori
        </x-button>
    </x-page-header>

    <!-- Card Wrapper -->
    <x-table>
        <x-slot name="header">
            <x-table.th>Icon</x-table.th>
            <x-table.th>Nama Kategori</x-table.th>
            <x-table.th>Deskripsi</x-table.th>
            <x-table.th>Urutan</x-table.th>
            <x-table.th class="text-right">Aksi</x-table.th>
        </x-slot>
        
        @forelse($categories as $category)
            <x-table.tr>
                <x-table.td>
                    @if($category->icon)
                        <div class="w-10 h-10 bg-[#eaf4f1] rounded-xl flex items-center justify-center text-[#2D735B]">
                            <i class="{{ $category->icon }}"></i>
                        </div>
                    @else
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                            -
                        </div>
                    @endif
                </x-table.td>
                <x-table.td class="font-medium text-gray-800">{{ $category->name }}</x-table.td>
                <x-table.td>{{ $category->description ?? '-' }}</x-table.td>
                <x-table.td>{{ $category->order }}</x-table.td>
                <x-table.td class="text-right">
                    <div class="flex justify-end gap-2">
                        <x-button @click="showModalEdit = true; editData = { id: {{ $category->id }}, name: '{{ addslashes($category->name) }}', description: '{{ addslashes($category->description) }}', order: {{ $category->order }}, icon: '{{ addslashes($category->icon) }}' }" color="warning" size="sm">Edit</x-button>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit" color="danger" size="sm">Hapus</x-button>
                        </form>
                    </div>
                </x-table.td>
            </x-table.tr>
        @empty
            <x-table.tr>
                <x-table.td colspan="5" class="text-center">
                    <div class="flex flex-col items-center justify-center text-gray-500 py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <p class="text-lg font-medium text-gray-600">Belum ada data kategori</p>
                        <p class="text-sm mt-1">Silakan tambahkan kategori baru terlebih dahulu.</p>
                    </div>
                </x-table.td>
            </x-table.tr>
        @endforelse
    </x-table>

    <!-- Modal Create -->
    <div x-show="showModalCreate" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModalCreate" @click="showModalCreate = false" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/50"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showModalCreate" x-transition class="relative z-10 inline-block w-full align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg">
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
                        <x-button type="submit" color="primary" size="md" class="w-full sm:w-auto sm:ml-3">Simpan</x-button>
                        <x-button @click="showModalCreate = false" color="outline" size="md" class="mt-3 w-full sm:mt-0 sm:ml-3 sm:w-auto">Batal</x-button>
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
            <div x-show="showModalEdit" x-transition class="relative z-10 inline-block w-full align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg">
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
                        <x-button type="submit" color="primary" size="md" class="w-full sm:w-auto sm:ml-3">Simpan Perubahan</x-button>
                        <x-button @click="showModalEdit = false" color="outline" size="md" class="mt-3 w-full sm:mt-0 sm:ml-3 sm:w-auto">Batal</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
