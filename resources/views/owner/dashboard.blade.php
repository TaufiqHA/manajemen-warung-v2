@extends('layout.owner')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Owner</h1>
        <p class="text-gray-600 mt-1">Ringkasan aktivitas dan pendapatan warung.</p>
    </div>

    <!-- Contoh Grid untuk Card Statistik sesuai style-rec.md -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="text-gray-500 font-medium text-sm">Total Pendapatan (Bulan ini)</h3>
            <p class="text-3xl font-bold text-[#2D735B] mt-2">Rp 0</p>
        </div>
        
        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="text-gray-500 font-medium text-sm">Total Transaksi</h3>
            <p class="text-3xl font-bold text-[#2D735B] mt-2">0</p>
        </div>
        
        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="text-gray-500 font-medium text-sm">Produk Terjual</h3>
            <p class="text-3xl font-bold text-[#2D735B] mt-2">0</p>
        </div>
    </div>
@endsection
