@extends('layout.layout')

@section('content')
<div x-data="{ addModalOpen: false, editModalOpen: false, editData: {} }">
    <x-page-header title="Daftar Produk" subtitle="Kelola produk untuk warung Anda">
        <x-button @click="addModalOpen = true" color="primary" size="lg" icon="plus">
            Tambah Produk
        </x-button>
    </x-page-header>

    <!-- Pesan Sukses -->
    @include('components.successAlert')

    <!-- Content Card -->
    <x-table>
        <x-slot name="header">
            <x-table.th>No</x-table.th>
            <x-table.th>Nama Produk</x-table.th>
            <x-table.th>Kategori</x-table.th>
            <x-table.th>Harga</x-table.th>
            <x-table.th>Stok</x-table.th>
            <x-table.th class="text-right">Aksi</x-table.th>
        </x-slot>
        
        @forelse ($products as $index => $product)
        <x-table.tr>
            <x-table.td>{{ $index + 1 }}</x-table.td>
            <x-table.td class="font-medium text-gray-800">{{ $product->name }}</x-table.td>
            <x-table.td>{{ $product->category->name ?? '-' }}</x-table.td>
            <x-table.td>Rp {{ number_format($product->price, 0, ',', '.') }}</x-table.td>
            <x-table.td>{{ $product->stock }} {{ $product->unit }}</x-table.td>
            <x-table.td class="text-right">
                <div class="flex justify-end gap-2">
                    <x-button @click="editData = {{ json_encode($product) }}; editModalOpen = true" color="warning" size="sm" icon="edit">Edit</x-button>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" color="danger" size="sm" icon="trash">Hapus</x-button>
                    </form>
                </div>
            </x-table.td>
        </x-table.tr>
        @empty
        <x-table.tr>
            <x-table.td colspan="6" class="text-center text-gray-500">Belum ada data produk.</x-table.td>
        </x-table.tr>
        @endforelse
    </x-table>
    
    <!-- Modal Tambah -->
    <div x-show="addModalOpen" style="display: none" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Tambah Produk</h2>
                <button @click="addModalOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('products.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Produk</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Stok</label>
                        <input type="number" name="stock" value="0" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Satuan</label>
                        <input type="text" name="unit" value="pcs" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kategori</label>
                    <select name="category_id" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800 appearance-none">
                        <option value="">-- Tanpa Kategori --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="2" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800"></textarea>
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <x-button @click="addModalOpen = false" color="secondary" size="md" class="!rounded-xl">Batal</x-button>
                    <x-button type="submit" color="primary" size="md">Simpan</x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div x-show="editModalOpen" style="display: none" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div @click.away="editModalOpen = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Edit Produk</h2>
                <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form :action="`/products/${editData.id}`" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Produk</label>
                    <input type="text" name="name" x-model="editData.name" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" x-model="editData.price" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Stok</label>
                        <input type="number" name="stock" x-model="editData.stock" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Satuan</label>
                        <input type="text" name="unit" x-model="editData.unit" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kategori</label>
                    <select name="category_id" x-model="editData.category_id" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800 appearance-none">
                        <option value="">-- Tanpa Kategori --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi Singkat</label>
                    <textarea name="description" x-model="editData.description" rows="2" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#2D735B] focus:bg-white transition-colors duration-300 text-gray-800"></textarea>
                </div>
                <div class="pt-4 flex justify-end gap-3">
                    <x-button @click="editModalOpen = false" color="secondary" size="md" class="!rounded-xl">Batal</x-button>
                    <x-button type="submit" color="primary" size="md">Simpan Perubahan</x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
