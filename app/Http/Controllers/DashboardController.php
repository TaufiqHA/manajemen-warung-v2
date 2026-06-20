<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ubah target view yang dirender menjadi file pages/dashboard.blade.php
        return view('pages.dashboard');
    }
}
