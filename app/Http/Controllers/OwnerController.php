<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        // Tempat mengambil data statistik di masa mendatang
        return view('owner.dashboard');
    }
}
