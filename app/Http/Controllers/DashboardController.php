<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menampilkan view yang berada di resources/views/layout/dashboard.blade.php
        return view('layout.dashboard');
    }
}
