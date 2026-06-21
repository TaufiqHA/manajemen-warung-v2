@extends('layout.layout')

@section('content')
<div x-data="{ 
    addModalOpen: false,
    products: {{ isset($products) ? json_encode($products) : '[]' }},
    items: [{ product_id: '', product_name: '', unit_price: 0, quantity: 1 }],
    discount_amount: 0,
    tax_amount: 0,
    updateItem(index) {
        let product = this.products.find(p => p.id == this.items[index].product_id);
        if (product) {
            this.items[index].product_name = product.name;
            this.items[index].unit_price = product.price;
        } else {
            this.items[index].product_name = '';
            this.items[index].unit_price = 0;
        }
    },
    addItem() {
        this.items.push({ product_id: '', product_name: '', unit_price: 0, quantity: 1 });
    },
    removeItem(index) {
        this.items.splice(index, 1);
    },
    get totalAmount() {
        return this.items.reduce((sum, item) => sum + (item.unit_price * item.quantity), 0);
    },
    get grandTotal() {
        return this.totalAmount - (Number(this.discount_amount) || 0) + (Number(this.tax_amount) || 0);
    }
}">
    <x-page-header title="Transaksi" subtitle="Kelola transaksi penjualan warung Anda">
        <x-button @click="addModalOpen = true" color="primary" size="lg" icon="plus">
            Tambah Transaksi Baru
        </x-button>
    </x-page-header>

    @include('components.successAlert')

    <x-table>
        <x-slot name="header">
            <x-table.th>Kode Trx</x-table.th>
            <x-table.th>Pelanggan</x-table.th>
            <x-table.th>Total Item</x-table.th>
            <x-table.th>Grand Total</x-table.th>
            <x-table.th>Metode</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th class="text-right">Aksi</x-table.th>
        </x-slot>

        @forelse ($transactions as $trx)
        <x-table.tr>
            <x-table.td class="font-medium text-gray-800">{{ $trx->transaction_code }}</x-table.td>
            <x-table.td>{{ $trx->customer_name ?? '-' }}</x-table.td>
            <x-table.td>{{ $trx->items->count() }} item</x-table.td>
            <x-table.td>Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</x-table.td>
            <x-table.td>{{ $trx->payment_method }}</x-table.td>
            <x-table.td>
                <span class="px-2 py-1 text-xs rounded-full {{ $trx->status == 'SUCCESS' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $trx->status }}
                </span>
            </x-table.td>
            <x-table.td class="text-right">
                <div class="flex justify-end gap-2">
                    <a href="{{ route('transactions.show', $trx->id) }}">
                        <x-button type="button" color="outline" size="sm">
                            <svg class="w-4 h-4 mr-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Detail
                        </x-button>
                    </a>
                    <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" color="danger" size="sm" icon="trash">Hapus</x-button>
                    </form>
                </div>
            </x-table.td>
        </x-table.tr>
        @empty
        <x-table.tr>
            <x-table.td colspan="7" class="text-center text-gray-500">Belum ada data transaksi.</x-table.td>
        </x-table.tr>
        @endforelse
    </x-table>

    <!-- Modal Tambah Transaksi Sederhana (Placeholder) -->
    <div x-show="addModalOpen" style="display: none" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div @click.away="addModalOpen = false" class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden transform transition-all">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Tambah Transaksi Sederhana</h2>
                <button @click="addModalOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('transactions.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Pelanggan</label>
                        <input type="text" name="customer_name" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2D735B]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Catatan</label>
                        <input type="text" name="note" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2D735B]" placeholder="Opsional">
                    </div>
                </div>
                
                <hr>
                <div class="flex justify-between items-center mb-2">
                    <p class="text-sm font-bold text-gray-700">Daftar Item Transaksi</p>
                    <button type="button" @click="addItem" class="text-xs bg-[#2D735B] text-white px-3 py-1 rounded-full hover:bg-[#245D49] transition-colors">+ Tambah Item</button>
                </div>
                
                <div class="space-y-3 max-h-48 overflow-y-auto pr-2">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="p-3 bg-gray-50 border border-gray-200 rounded-xl relative">
                            <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="absolute top-2 right-2 text-red-500 hover:text-red-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            
                            <div class="grid grid-cols-12 gap-2">
                                <div class="col-span-8">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Produk</label>
                                    <select x-model="item.product_id" @change="updateItem(index)" :name="`items[${index}][product_id]`" required class="w-full px-2 py-1.5 text-sm bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2D735B]">
                                        <option value="">-- Pilih Produk --</option>
                                        <template x-for="product in products" :key="product.id">
                                            <option :value="product.id" x-text="product.name + ' - Rp' + product.price.toLocaleString('id-ID')"></option>
                                        </template>
                                    </select>
                                    <input type="hidden" :name="`items[${index}][product_name]`" x-model="item.product_name">
                                    <input type="hidden" :name="`items[${index}][unit_price]`" x-model="item.unit_price">
                                </div>
                                <div class="col-span-4">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Qty</label>
                                    <input type="number" x-model.number="item.quantity" :name="`items[${index}][quantity]`" required min="1" class="w-full px-2 py-1.5 text-sm bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2D735B]">
                                </div>
                            </div>
                            <div class="mt-2 text-right text-xs font-bold text-[#2D735B]">
                                Subtotal: Rp <span x-text="(item.unit_price * item.quantity).toLocaleString('id-ID')"></span>
                            </div>
                        </div>
                    </template>
                </div>
                
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Diskon (Rp)</label>
                        <input type="number" x-model="discount_amount" name="discount_amount" min="0" class="w-full px-3 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2D735B]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Pajak (Rp)</label>
                        <input type="number" x-model="tax_amount" name="tax_amount" min="0" class="w-full px-3 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2D735B]">
                    </div>
                </div>

                <div class="flex flex-col space-y-1 pt-3 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">Subtotal Item:</span>
                        <span class="text-sm text-gray-600">Rp <span x-text="totalAmount.toLocaleString('id-ID')"></span></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-700">Grand Total:</span>
                        <span class="text-lg font-bold text-[#2D735B]">Rp <span x-text="grandTotal.toLocaleString('id-ID')"></span></span>
                    </div>
                </div>
                
                <hr>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Metode Pembayaran</label>
                        <select name="payment_method" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2D735B]">
                            <option value="CASH">CASH</option>
                            <option value="TRANSFER">TRANSFER</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jumlah Bayar (Rp)</label>
                        <input type="number" name="paid_amount" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2D735B]">
                    </div>
                </div>
                
                <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 mt-4">
                    <x-button @click="addModalOpen = false" color="secondary" size="md" class="!rounded-xl">Batal</x-button>
                    <x-button type="submit" color="primary" size="md">Simpan Transaksi</x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
