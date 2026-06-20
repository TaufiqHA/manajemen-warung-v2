<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user BELUM login
        if (!Auth::check()) {
            // Jika belum login, kembalikan secara paksa ke halaman login (rute '/')
            return redirect('/');
        }

        // Jika user sudah login, teruskan ke halaman yang dituju
        return $next($request);
    }
}
