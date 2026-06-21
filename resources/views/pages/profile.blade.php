@extends('layout.layout')

@section('content')
<div class="w-full max-w-4xl space-y-6">
    <!-- Edit Profile Card -->
    <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8">
        <h2 class="text-gray-800 font-bold text-xl mb-1">Edit Profile</h2>
        <p class="text-gray-600 mb-6 text-sm">Perbarui informasi profil dan alamat email akun Anda.</p>

        @if(session('success') && !str_contains(session('success'), 'Password'))
            <div class="mb-4 p-4 rounded-2xl bg-green-100 text-green-700 border border-green-200 shadow-sm flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-gray-600 font-medium text-sm mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="w-full rounded-full border-gray-300 text-gray-800 focus:ring-2 focus:ring-[#2D735B] transition-colors duration-300 shadow-sm p-3" required autofocus>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-gray-600 font-medium text-sm mb-1">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="w-full rounded-full border-gray-300 text-gray-800 focus:ring-2 focus:ring-[#2D735B] transition-colors duration-300 shadow-sm p-3" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-[#2D735B] hover:bg-[#245D49] text-white rounded-full px-6 py-2.5 font-medium transition-colors duration-300 shadow-sm text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password Card -->
    <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8">
        <h2 class="text-gray-800 font-bold text-xl mb-1">Ubah Password</h2>
        <p class="text-gray-600 mb-6 text-sm">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>

        @if(session('success') && str_contains(session('success'), 'Password'))
            <div class="mb-4 p-4 rounded-2xl bg-green-100 text-green-700 border border-green-200 shadow-sm flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-gray-600 font-medium text-sm mb-1">Password Saat Ini</label>
                <input type="password" name="current_password" id="current_password" class="w-full rounded-full border-gray-300 text-gray-800 focus:ring-2 focus:ring-[#2D735B] transition-colors duration-300 shadow-sm p-3" required>
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="new_password" class="block text-gray-600 font-medium text-sm mb-1">Password Baru</label>
                <input type="password" name="new_password" id="new_password" class="w-full rounded-full border-gray-300 text-gray-800 focus:ring-2 focus:ring-[#2D735B] transition-colors duration-300 shadow-sm p-3" required>
                @error('new_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="new_password_confirmation" class="block text-gray-600 font-medium text-sm mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full rounded-full border-gray-300 text-gray-800 focus:ring-2 focus:ring-[#2D735B] transition-colors duration-300 shadow-sm p-3" required>
                @error('new_password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-[#2D735B] hover:bg-[#245D49] text-white rounded-full px-6 py-2.5 font-medium transition-colors duration-300 shadow-sm text-sm">
                    Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
