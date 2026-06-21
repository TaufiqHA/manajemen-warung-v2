@extends('layout.layout')

@section('content')
<x-page-header title="Detail Transaksi: {{ $transaction->transaction_code }}" subtitle="Informasi lengkap transaksi pembayaran">
    <a href="{{ route('transactions.index') }}">
        <x-button color="secondary" size="lg">
            Kembali
        </x-button>
    </a>
</x-page-header>

<div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Nama Pelanggan</p>
            <p class="text-base font-bold text-gray-800">{{ $transaction->customer_name ?? '-' }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Tanggal</p>
            <p class="text-base font-bold text-gray-800">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Metode Pembayaran</p>
            <p class="text-base font-bold text-gray-800">{{ $transaction->payment_method }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Status</p>
            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $transaction->status == 'SUCCESS' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $transaction->status }}
            </span>
        </div>
        <div class="col-span-2 md:col-span-4">
            <p class="text-sm font-medium text-gray-500 mb-1">Catatan</p>
            <p class="text-base text-gray-800">{{ $transaction->note ?? '-' }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-800">Daftar Item</h3>
    </div>
    <x-table>
        <x-slot name="header">
            <x-table.th>No</x-table.th>
            <x-table.th>Produk</x-table.th>
            <x-table.th class="text-right">Harga Satuan</x-table.th>
            <x-table.th class="text-center">Qty</x-table.th>
            <x-table.th class="text-right">Subtotal</x-table.th>
        </x-slot>

        @foreach ($transaction->items as $index => $item)
        <x-table.tr>
            <x-table.td>{{ $index + 1 }}</x-table.td>
            <x-table.td class="font-medium text-gray-800">{{ $item->product_name }}</x-table.td>
            <x-table.td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</x-table.td>
            <x-table.td class="text-center">{{ $item->quantity }}</x-table.td>
            <x-table.td class="text-right font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</x-table.td>
        </x-table.tr>
        @endforeach
    </x-table>
    
    <div class="p-6 bg-gray-50 flex flex-col items-end space-y-2">
        <div class="flex justify-between w-full md:w-1/3">
            <span class="text-sm font-medium text-gray-500">Total Item:</span>
            <span class="text-sm font-bold text-gray-700">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between w-full md:w-1/3">
            <span class="text-sm font-medium text-gray-500">Diskon:</span>
            <span class="text-sm font-bold text-red-500">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between w-full md:w-1/3">
            <span class="text-sm font-medium text-gray-500">Pajak:</span>
            <span class="text-sm font-bold text-gray-700">+ Rp {{ number_format($transaction->tax_amount, 0, ',', '.') }}</span>
        </div>
        <hr class="w-full md:w-1/3 border-gray-200">
        <div class="flex justify-between w-full md:w-1/3 items-center">
            <span class="text-base font-bold text-gray-800">Grand Total:</span>
            <span class="text-xl font-bold text-[#2D735B]">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
        </div>
        
        <div class="flex justify-between w-full md:w-1/3 mt-4 pt-4 border-t border-gray-200">
            <span class="text-sm font-medium text-gray-500">Jumlah Bayar:</span>
            <span class="text-sm font-bold text-gray-700">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between w-full md:w-1/3">
            <span class="text-sm font-medium text-gray-500">Kembalian:</span>
            <span class="text-sm font-bold text-gray-700">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endsection
