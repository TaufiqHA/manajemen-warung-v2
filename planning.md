# Transaction Detail Feature Implementation Plan

Dokumen ini berisi panduan langkah demi langkah untuk mengimplementasikan fitur Halaman Detail Transaksi. Panduan ini dirancang agar mudah diimplementasikan oleh Junior Developer atau AI assistant secara terstruktur.

**PENTING (TAMPILAN UI/UX)**:
- Untuk semua pembuatan tampilan (layout) khususnya pada halaman Detail Transaksi yang baru, **WAJIB** mengacu pada pedoman di file `style-rec.md` agar desain visual tetap konsisten.
- Gunakan komponen-komponen UI yang sudah tersedia di folder `resources/views/components` (seperti `<x-button>`, `<x-page-header>`, `<x-table>`, dll) daripada membuat elemen HTML mentah.

## Daftar File yang Akan Berubah/Dibuat

**Dibuat:**
1. `resources/views/pages/transactionDetail.blade.php` (Halaman View untuk menampilkan rincian dari transaksi)

**Diubah:**
1. `resources/views/pages/transaction.blade.php` (Tabel utama, untuk menambahkan tombol "Detail")
2. `app/Http/Controllers/TransactionController.php` (Menambahkan logika pada method `show` untuk merender view)

---

## Langkah 1: Implementasi Method Show pada Controller

**Edit File:** `app/Http/Controllers/TransactionController.php`

**Instruksi:**
1. Karena `routes/web.php` sudah menggunakan `Route::resource('transactions', ...)` secara otomatis, rute `transactions.show` sudah aktif. Kita hanya perlu mengimplementasi method `show`.
2. Buat atau cari method `show($id)`.
3. Gunakan Eloquent untuk mengambil data transaksi beserta relasi itemnya: `Transaction::with('items')->findOrFail($id);`
4. Lakukan *return view* ke `pages.transactionDetail` dan bawa variabel transaksi tersebut.

**Contoh Logic:**
```php
public function show($id)
{
    $transaction = Transaction::with('items')->findOrFail($id);
    
    return view('pages.transactionDetail', compact('transaction'));
}
```

## Langkah 2: Pembuatan Halaman Detail Transaksi (Frontend)

**Buat File Baru:** `resources/views/pages/transactionDetail.blade.php`

**Instruksi Khusus untuk View:**
1. Rujuk file `style-rec.md` agar gaya desain seragam. Pastikan halaman di-*wrap* dengan `@extends('layout.layout')` dan `@section('content')`.
2. Gunakan komponen `<x-page-header>` dengan judul misalnya "Detail Transaksi: [KODE_TRANSAKSI]". Di dalamnya, sediakan tombol "Kembali" yang memanggil `route('transactions.index')`.
3. Buat kerangka desain yang rapi (bisa dua kolom Grid atau model Struk/Invoice). Tampilkan informasi utama Master:
   - Kode Transaksi
   - Nama Pelanggan
   - Tanggal
   - Status, Metode Pembayaran
   - Catatan
4. Gunakan komponen `<x-table>` untuk merender list/daftar barang (`$transaction->items`) beserta:
   - Nama Produk
   - Harga Satuan
   - Kuantitas (Qty)
   - Subtotal
5. Di bagian bawah tabel, tampilkan rangkuman totalnya:
   - Total Item
   - Diskon
   - Pajak
   - **Grand Total**
   - Jumlah Bayar (Nominal)
   - Kembalian

## Langkah 3: Modifikasi Tabel Utama Transaksi

**Edit File:** `resources/views/pages/transaction.blade.php`

**Instruksi:**
1. Buka file tabel indeks transaksi.
2. Cari bagian kolom tabel "Aksi" (di dalam pengulangan `@forelse`).
3. Tambahkan tombol baru ("Detail") tepat di sebelah tombol "Hapus" yang sudah ada. Tombol ini harus berbentuk *link* atau elemen yang mengarah ke endpoint `transactions.show`.

**Contoh Implementasi:**
```html
<div class="flex justify-end gap-2">
    <!-- Tombol Detail -->
    <a href="{{ route('transactions.show', $trx->id) }}">
        <x-button type="button" color="secondary" size="sm" icon="eye">Detail</x-button>
    </a>
    
    <!-- Tombol Hapus (Sudah ada) -->
    <form action="..." ...>
       ...
    </form>
</div>
```

---
**Catatan Implementasi Tambahan:** 
Pastikan ukuran tombol seragam dan warna merepresentasikan peruntukannya (contoh: *secondary* atau *info* untuk detail). Lakukan _commit_ setelah selesai merangkai komponen.
