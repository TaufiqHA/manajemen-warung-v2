# Planning: Fitur Product

## Deskripsi Tugas

Implementasi fitur CRUD (Create, Read, Update, Delete) untuk produk. Tugas ini meliputi pembuatan tabel database, model, controller, tampilan (view), konfigurasi routing, serta pembuatan unit test. Instruksi ini disusun agar mudah diikuti langkah demi langkah.

## File yang Akan Dibuat/Diubah

- 🟢 **`database/migrations/xxxx_xx_xx_xxxxxx_create_products_table.php`** (Baru)
- 🟢 **`app/Models/Product.php`** (Baru)
- 🟢 **`app/Http/Controllers/ProductController.php`** (Baru)
- 🟢 **`resources/views/pages/product.blade.php`** (Baru)
- 🟡 **`routes/web.php`** (Update)
- 🟢 **`tests/Feature/ProductTest.php`** (Baru)

---

## Langkah-Langkah Implementasi

### 1. Database Migration

Jalankan perintah terminal berikut untuk membuat file migration:

```bash
php artisan make:migration create_products_table
```

> **Perhatian:** JANGAN jalankan `php artisan migrate` setelah file dibuat. Cukup buat struktur tabelnya saja.

Buka file migration yang baru terbuat di folder `database/migrations/` dan lengkapi method `up()` dengan schema berikut:

```php
Schema::create('products', function (Blueprint $table) {
    $table->id(); // id bigint [pk, increment]
    $table->foreignId('warung_id')->constrained('warungs'); // warung_id bigint
    $table->foreignId('category_id')->constrained('categories')->nullable(); // category_id bigint [null]
    $table->string('name'); // name varchar
    $table->text('description')->nullable(); // description text [null]
    $table->bigInteger('price'); // price bigint
    $table->integer('order')->default(0); // order int [default: 0]
    $table->integer('stock')->default(0); // stock int [default: 0]
    $table->string('unit')->default('pcs'); // unit varchar [default: 'pcs']
    $table->string('image_url')->nullable(); // image_url varchar [null]
    $table->boolean('is_active')->default(true); // is_active boolean [default: true]
    $table->timestamps(); // created_at, updated_at
});
```

### 2. Model

Jalankan perintah berikut untuk membuat model:

```bash
php artisan make:model Product
```

Buka file `app/Models/Product.php` dan tambahkan properti `$fillable` agar data dapat disimpan. Daftarkan semua kolom tabel (kecuali id dan timestamps) ke dalam `$fillable`.

### 3. Controller

Jalankan perintah berikut untuk membuat controller:

```bash
php artisan make:controller ProductController
```

Buka file `app/Http/Controllers/ProductController.php` dan buat 4 fungsi utama:

- `index()`: Ambil seluruh data produk dan kirim (return view) ke `pages.product`.
- `store(Request $request)`: Lakukan validasi input, simpan produk baru ke database, dan return redirect dengan pesan sukses.
- `update(Request $request, $id)`: Cari produk berdasarkan ID, lakukan validasi input, update data di database, dan return redirect dengan pesan sukses.
- `destroy($id)`: Cari produk berdasarkan ID, hapus dari database, dan return redirect dengan pesan sukses.

### 4. Routing

Buka file `routes/web.php` dan daftarkan endpoint untuk `ProductController`. Pastikan rute diletakkan dalam middleware otentikasi (jika sistem warung membutuhkannya):

```php
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
```

### 5. View (Tampilan)

Buat file `product.blade.php` di dalam direktori `resources/views/pages/`.

- Rancang tampilan untuk memuat tabel/daftar produk.
- Siapkan komponen formulir (bisa berbentuk modal) untuk fungsi Tambah dan Edit produk.
- **Catatan Penting:** Gunakan `style-rec.md` sebagai referensi tunggal panduan desain (styling guide). Pastikan struktur HTML, CSS class (misal jika memakai Tailwind), atau komponen UI mengikuti standar dari `style-rec.md` agar antarmuka konsisten.

### 6. Unit Testing

Jalankan perintah berikut untuk membuat file testing:

```bash
php artisan make:test ProductTest
```

Buka file `tests/Feature/ProductTest.php` dan buat pengujian untuk memverifikasi fungsionalitas dari method Controller. Contohnya:

- Test apakah endpoint index dapat diakses dengan sukses (Status 200).
- Test apakah produk baru dapat disimpan ke database melalui endpoint store.
- Test apakah produk dapat diperbarui.
- Test apakah produk dapat dihapus dari database.
