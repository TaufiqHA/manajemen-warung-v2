<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Tangkap apakah checkbox "remember me" dicentang atau tidak (menghasilkan true/false)
        $remember = $request->has('remember');

        // 3. Panggil Auth::attempt dengan menyertakan argumen $remember
        if (Auth::attempt($credentials, $remember)) {
            // 4. Regenerate session id (untuk mencegah celah session fixation)
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // 4. Jika gagal, kembalikan pesan error
        return response()->json([
            'message' => 'Email atau password salah'
        ], 401);
    }

    public function me(Request $request)
    {
        // 1. Ambil data user yang sedang login
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'user' => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        // 1. Lakukan proses logout
        Auth::logout();

        // 2. Invalidate session dan regenerate token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. Kembalikan response sukses
        return redirect('/')->with('message', 'Berhasil logout');
    }
}
