<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Warung;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat data warung dummy sebagai syarat foreign key (jika belum ada)
        $warung = Warung::firstOrCreate(
            ["id" => 1],
            ["name" => "Warung Pusat", "address" => "Jl. Pusat Bisnis"],
        );

        // 2. Generate / Create akun Admin menggunakan updateOrCreate agar tidak terjadi duplikat saat dijalankan berkali-kali
        User::updateOrCreate(
            ["email" => "admin@pos.com"], // Pencarian berdasarkan email
            [
                "warung_id" => $warung->id,
                "name" => "Admin Warung",
                "username" => "admin",
                "password" => bcrypt("password"),
                "phone" => "081234567890",
                "role" => "OWNER",
                "is_active" => true,
            ],
        );
    }
}
