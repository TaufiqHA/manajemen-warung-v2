# Perencanaan Implementasi Global Search (Headbar)

## 🎯 Tujuan
Membuat fitur pencarian pada komponen `headbar.blade.php` berfungsi secara dinamis dan kontekstual. Pencarian akan selalu menyesuaikan dengan halaman/modul yang sedang dibuka oleh pengguna (misalnya: saat berada di halaman Transaksi, akan mencari transaksi; saat di halaman Produk, akan mencari produk).

## 📝 1. Modifikasi Frontend (Komponen Headbar)
- **File Target**: `resources/views/components/headbar.blade.php`
- **Tindakan**:
  - Bungkus tag `<input>` pencarian yang sudah ada dengan tag `<form>`.
  - Atur **Method** form menjadi `GET`.
  - Atur **Action** form menjadi `{{ url()->current() }}` agar parameter dikirimkan ke halaman yang saat ini sedang aktif.
  - Tambahkan atribut `name="search"` pada tag `<input>`.
  - Tambahkan nilai default `value="{{ request('search') }}"` pada input agar keyword tidak hilang (tetap bertahan di kotak pencarian) setelah pengguna menekan enter/mencari.

*(Catatan: Langkah ini sudah dikerjakan dan sekarang headbar siap digunakan di seluruh halaman).*

## ⚙️ 2. Penyesuaian Backend (Controller)
Untuk setiap halaman yang membutuhkan dukungan fitur *search*, fungsi penampil datanya (biasanya method `index`) perlu dimodifikasi. 
- **Tindakan**:
  - Tangkap request pencarian dengan logika kondisi `if ($request->filled('search'))`.
  - Terapkan filter pencarian pada *Query Builder* / *Eloquent* menggunakan operator `like` (berdasarkan kolom tabel yang ingin dicari, seperti nama atau kode).
  - Jika menggunakan *pagination*, pastikan parameter pencarian disematkan ke *link pagination* menggunakan `appends(['search' => $request->search])`.

### Contoh Skema pada `TransactionController` (Sudah Selesai)
- **Kolom Target Pencarian**: `transaction_code` atau `customer_name`.
- **Implementasi**: 
  ```php
  if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function($q) use ($search) {
          $q->where('transaction_code', 'like', "%{$search}%")
            ->orWhere('customer_name', 'like', "%{$search}%");
      });
  }
  ```

## 🚀 3. Panduan untuk Halaman Lainnya (Next Steps)
Jika nantinya akan mengaktifkan *search* di modul lain (misalnya halaman **Produk** atau **Kategori**):
1. Buka file Controller yang bersangkutan (contoh: `ProductController.php`).
2. Cari method `index` yang merender tabel data.
3. Ubah query pengambilan data menjadi sebuah *instance Query Builder* (misal: `$query = Product::query();`).
4. Terapkan logika pengecekan `if ($request->filled('search')) { ... }` yang memfilter nama produk atau SKU.
5. Jalankan eksekusi query (contoh: `$products = $query->paginate(10)->appends(['search' => $request->search]);`).
6. Tidak perlu menyentuh file HTML lagi, fitur langsung terhubung otomatis.
