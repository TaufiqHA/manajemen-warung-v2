<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="flex min-h-screen w-full bg-white font-sans">

    <!-- Kolom Kiri: Bagian Ilustrasi (Disembunyikan di layar mobile) -->
    <div class="hidden lg:flex lg:w-1/2 items-center justify-center bg-white p-12">
        <!-- Ganti src dengan aset ilustrasi orang di depan laptop yang sesuai -->
        <img src="{{ asset('storage/icon/Mobile login-bro.png') }}" alt="Login Illustration" class="max-w-md">
    </div>

    <!-- Kolom Kanan: Bagian Form Login (Background Hijau Muda) -->
    <!-- Menggunakan bg-green-400 sebagai pengganti warna biru asli -->
    <div class="w-full lg:w-1/2 bg-green-400 flex items-center justify-center relative overflow-hidden p-6">

        <!-- Ornamen garis melengkung di pojok kanan bawah -->
        <div class="absolute -bottom-16 -right-16 w-64 h-64 border-4 border-green-300/50 rounded-full"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 border-4 border-green-300/50 rounded-full"></div>

        <!-- Card Form Login (Warna Putih) -->
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 sm:p-10 z-10">
            <!-- Header Teks -->
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Hello!</h1>
            <p class="text-gray-500 mb-8">Sign Up to Get Started</p>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Input Email -->
                <div class="relative mb-5">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <!-- Icon Amplop / Email -->
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <!-- Fokus border juga menggunakan warna hijau muda -->
                    <input type="email" name="email" placeholder="Email Address" required
                           class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:border-green-400 focus:ring-1 focus:ring-green-400 text-gray-700 placeholder-gray-400 transition-colors">
                </div>

                <!-- Input Password -->
                <div class="relative mb-6">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <!-- Icon Gembok / Password -->
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input type="password" name="password" placeholder="Password" required
                           class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:border-green-400 focus:ring-1 focus:ring-green-400 text-gray-700 placeholder-gray-400 transition-colors">
                </div>

                <!-- Tombol Login (Warna Hijau Muda) -->
                <button type="submit"
                        class="w-full bg-green-400 hover:bg-green-500 text-white font-bold py-3 px-4 rounded-full transition duration-300">
                    Login
                </button>
            </form>

            <!-- Lupa Password (Rata Kiri) -->
            <div class="mt-6">
                <a href="#" class="text-sm text-gray-500 hover:text-green-500 font-medium transition-colors">
                    Forgot Password
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
