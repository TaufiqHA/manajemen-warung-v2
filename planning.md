# Planning: Mengambil dan Menampilkan Inisial Nama di Headbar

## 🎯 Tujuan

Mengambil data pengguna (`/me`), mengekstrak properti `name`, dan menjadikannya sebagai _Icon Avatar_ (inisial huruf) pada komponen headbar untuk menggantikan teks statis "YN".

## 📁 File yang Diubah

- `resources/views/components/headbar.blade.php`

## 🎨 Panduan Desain (Berdasarkan `style-rec.md`)

Sesuai dengan standar UI proyek Manajemen Warung:

- Tetap gunakan kelas bawaan avatar: `rounded-full` (untuk _pill shape_ / membulat), `bg-white`, dan `text-[#2D735B]` (Primary Dark Green).
- Jangan ubah ukuran (`w-8 h-8 md:w-10 md:h-10`) atau font (`font-bold`) agar konsisten dengan antarmuka yang ada.

---

## 🛠️ Langkah-langkah Implementasi

Berdasarkan arsitektur yang umum di Laravel, pilihlah salah satu dari dua pendekatan di bawah ini yang paling sesuai dengan sistem Anda saat ini.

### Opsi 1: Menggunakan Laravel Auth (Sangat Direkomendasikan jika Non-API)

Jika data "`/me`" merujuk pada pengguna yang sedang aktif (login) di _session_ Laravel, gunakan _helper_ bawaan Laravel secara langsung di file blade. Ini sangat mudah dan cepat diimplementasikan.

**Langkah-langkah:**

1. Buka file `resources/views/components/headbar.blade.php`.
2. Tepat di atas baris komentar `<!-- Profile Avatar -->`, tambahkan logika PHP untuk mengambil nama _user_ dan memecahnya menjadi inisial (maksimal 2 karakter).
3. Ganti teks `YN` di dalam tag `<div>` avatar dengan variabel inisial tersebut.

**Contoh Kode (Copy-Paste Ready):**

```html
<!-- Actions Pill -->
<div
    class="flex items-center bg-[#2D735B] rounded-full p-1 md:p-1.5 space-x-2 md:space-x-6 shadow ml-2"
>
    <!-- Notification -->
    <button class="pl-3 text-white hover:text-gray-200 transition">
        <svg
            class="w-5 h-5 md:w-5 md:h-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
            />
        </svg>
    </button>

    <!-- Profile Avatar -->
    @php // Mengambil nama user yang login, fallback ke 'User Name' jika gagal
    $name = auth()->check() ? auth()->user()->name : 'User Name'; $words =
    explode(' ', trim($name)); $initials = ''; // Ambil huruf pertama kata ke-1
    if (isset($words[0]) && strlen($words[0]) > 0) { $initials .=
    strtoupper(substr($words[0], 0, 1)); } // Ambil huruf pertama kata ke-2 if
    (isset($words[1]) && strlen($words[1]) > 0) { $initials .=
    strtoupper(substr($words[1], 0, 1)); } @endphp

    <div
        class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-white flex items-center justify-center text-[#2D735B] font-bold text-xs md:text-sm mr-0.5 md:mr-1"
    >
        {{ $initials ?: 'YN' }}
    </div>
</div>
```

## 📝 Rekomendasi Eksekusi

Untuk **AI Model** atau **Junior Developer**, disarankan menggunakan **Opsi 1** apabila proyek _Manajemen Warung v2_ ini murni menggunakan arsitektur Blade & Route Laravel biasa (non-API), karena lebih ringan dan tidak bergantung pada _HTTP Request_ di _frontend_.
