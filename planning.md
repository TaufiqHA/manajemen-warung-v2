# Planning: Fitur Profile User

Dokumen ini berisi langkah-langkah implementasi fitur Profile User, termasuk melihat data, mengubah profil, dan mengubah password.

## 🗂️ Daftar File yang Ditambahkan & Diubah

**Ditambahkan:**
- `resources/views/pages/profile.blade.php`
- `app/Http/Controllers/ProfileController.php`
- `tests/Feature/ProfileControllerTest.php`

**Diubah:**
- `routes/web.php`

---

## 📝 Langkah-langkah Implementasi

### Langkah 1: Membuat Controller
Jalankan perintah artisan berikut di terminal:
```bash
php artisan make:controller ProfileController
```

**Instruksi Implementasi `ProfileController.php`:**
- **`index()`**: Ambil data user yang sedang login via `auth()->user()`, lalu arahkan ke view `pages.profile` dengan membawa data tersebut.
- **`update(Request $request)`**: 
  - Validasi input (`name` wajib, `email` wajib dan unique selain user ini).
  - Update data user di database.
  - Redirect kembali (`back()`) dengan _flash message_ sukses.
- **`updatePassword(Request $request)`**:
  - Validasi input (`current_password`, `new_password`, `new_password_confirmation`).
  - Cek apakah `current_password` cocok dengan password user saat ini menggunakan `Hash::check`. Jika salah, kembalikan pesan error validasi.
  - Jika benar, update password user dengan password baru yang sudah di-hash (`Hash::make`).
  - Redirect kembali dengan _flash message_ sukses.

### Langkah 2: Mendaftarkan Route
Buka `routes/web.php` dan tambahkan route berikut di dalam grup middleware `auth`:
```php
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
```

### Langkah 3: Membuat Layout Halaman Profile
Buat file baru di `resources/views/pages/profile.blade.php`.

**Panduan Styling Khusus (Mengacu ke `style-rec.md`):**
- Layout halaman harus menggunakan struktur wrapper utama dashboard.
- **Container / Card**: Gunakan warna latar `bg-white` atau `bg-[#f8fcfb]` dengan `rounded-2xl` dan `shadow-sm` untuk membungkus tiap-tiap form (satu card untuk Edit Profile, satu card untuk Ganti Password).
- **Input Text**: Semua `<input>` harus menggunakan bentuk `rounded-full`, teks `text-gray-800`, dan memiliki efek fokus `focus:ring-2 focus:ring-[#2D735B] transition-colors duration-300`.
- **Button / Tombol Simpan**: Gunakan warna `bg-[#2D735B]` dengan bentuk `rounded-full` dan teks putih (`text-white`). Berikan efek hover `hover:bg-[#245D49] transition-colors duration-300`.
- **Typografi**: Gunakan `text-gray-800 font-bold` untuk judul form, dan `text-gray-600` untuk deskripsi/label.

### Langkah 4: Membuat dan Implementasi Test
Jalankan perintah berikut:
```bash
php artisan make:test ProfileControllerTest
```

**Instruksi Implementasi `ProfileControllerTest.php`:**
- **`test_profile_page_is_displayed`**: Buat _dummy user_, jalankan fitur login sebagai user tersebut (`actingAs`), lakukan GET request ke `/profile`, pastikan mengembalikan status `200`.
- **`test_profile_information_can_be_updated`**: Login sebagai user, lakukan PUT request ke `/profile` dengan membawa data `name` dan `email` baru. Pastikan tidak ada error di session dan data user di database ikut berubah.
- **`test_password_can_be_updated`**: Login sebagai user, lakukan PUT request ke `/profile/password` dengan membawa data `current_password`, `password` (baru), dan `password_confirmation`. Lakukan pengecekan dengan `Hash::check` untuk memastikan password user di database telah berubah.
- **`test_correct_password_must_be_provided_to_update_password`**: Pastikan validasi gagal jika `current_password` yang dimasukkan tidak sama dengan password asli user saat ini.
