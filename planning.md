# Planning Pembuatan Dashboard Owner & OwnerController

Dokumen ini berisi langkah-langkah implementasi untuk membuat halaman *Dashboard* khusus *Owner*, serta pembuatan *Controller* yang akan menangani proses *backend*-nya. Dokumen ini dirancang agar mudah diikuti oleh Junior Developer atau AI Model.

**Penting:** Panduan styling untuk setiap perubahan tampilan wajib merujuk pada `style-rec.md` agar konsisten. Selalu maksimalkan penggunaan komponen yang sudah ada di folder `components`.

## 📁 Daftar File yang Terlibat
**File yang akan ditambahkan:**
1. `app/Http/Controllers/OwnerController.php` (Otomatis dibuat via artisan command)
2. `resources/views/owner/dashboard.blade.php`

**File yang akan diubah:**
1. `routes/web.php` (Menambahkan route untuk halaman dashboard owner)

---

## 🛠️ Langkah-Langkah Implementasi

### Langkah 1: Membuat OwnerController via Artisan
**Tujuan:** Membuat controller untuk menangani logika halaman dan fitur khusus Owner.

**Instruksi:**
1. Buka terminal di *root directory* proyek.
2. Jalankan perintah artisan berikut untuk membuat *controller*:
   ```bash
   php artisan make:controller OwnerController
   ```
3. Buka file hasil *generate* yang berada di `app/Http/Controllers/OwnerController.php`.
4. Buat fungsi `index` yang akan mengembalikan (*return*) file *view* halaman dashboard owner.

*Contoh Kode di `OwnerController.php`:*
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        // Tempat mengambil data statistik di masa mendatang
        return view('owner.dashboard');
    }
}
```

---

### Langkah 2: Membuat File Tampilan `dashboard.blade.php`
**File:** `resources/views/owner/dashboard.blade.php`

**Tujuan:** Menyusun halaman tampilan dasbor Owner, yang berjalan di dalam *layout* `owner.blade.php` yang sudah dibuat sebelumnya.

**Instruksi:**
1. Buat folder baru bernama `owner` di dalam direktori `resources/views/` (jika belum ada).
2. Buat file bernama `dashboard.blade.php` di dalam folder tersebut.
3. *Extend* halaman ke kerangka layout Owner (`layout.owner`).
4. Isi blok `@section('content')` dengan struktur antarmuka (*UI*) sederhana yang mengikuti panduan dari `style-rec.md`.

*Contoh Struktur `dashboard.blade.php`:*
```blade
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
```

---

### Langkah 3: Mendaftarkan Route di `web.php`
**File:** `routes/web.php`

**Tujuan:** Mengarahkan *URL* dari halaman web ke fungsi `index` di `OwnerController`.

**Instruksi:**
1. Buka file `routes/web.php`.
2. *Import* class `OwnerController` di bagian paling atas.
3. Tambahkan route `GET` yang mengarah ke metode `index` dari `OwnerController`. Beri nama rutenya (`name`) dan pastikan untuk membungkus rute ini dalam _middleware auth_.

*Contoh Penambahan di `web.php`:*
```php
use App\Http\Controllers\OwnerController;

// Route untuk Owner
Route::get('/owner/dashboard', [OwnerController::class, 'index'])
    ->name('owner.dashboard')
    ->middleware('auth');
```

## 📝 Catatan Tambahan (Sesuai `style-rec.md`)
- Gunakan pembungkus data / kotak panel (*Card*) dengan *class* `bg-white p-6 rounded-2xl shadow-sm`.
- Gunakan warna hijau kebanggaan aplikasi (`text-[#2D735B]`) untuk memberi *highlight* pada informasi atau angka yang penting.
- Hirarki teks: `text-gray-800` (Judul besar), `text-gray-600` (Paragraf/Sub-teks), dan `text-gray-500` (Teks hint/label kecil).
- Tolong jangan menggunakan variasi warna baru yang acak (misal, tidak boleh asal pakai `text-blue-500`) tanpa konfirmasi, agar desain tetap terkesan mewah dan menyatu.
