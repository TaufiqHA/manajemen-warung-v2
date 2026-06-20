<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase; 

    protected function setUp(): void
    {
        parent::setUp();
        // Mematikan constraint pengecekan kunci asing sementara, 
        // guna mempermudah pembuatan dummy User tanpa harus membuat record tabel Warung dulu
        Schema::disableForeignKeyConstraints();
        
        // Membantu SQLite test environment agar insert sukses
        \Illuminate\Support\Facades\DB::table('warungs')->insertOrIgnore(['id' => 1, 'name' => 'Dummy Warung']);
    }

    public function test_user_can_login_with_valid_credentials()
    {
        // 1. Setup: Buat data user dummy
        $user = User::factory()->create([
            'warung_id' => 1,
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        // 2. Action: Hit endpoint login menggunakan postJson
        $response = $this->postJson('/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        // 3. Assert: Pastikan response redirect ke /dashboard
        $response->assertRedirect('/dashboard');
                 
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_user_can_access_me_endpoint()
    {
        // 1. Setup: Buat data user
        $user = User::factory()->create(['warung_id' => 1]);

        // 2. Action: Login (actingAs) lalu hit endpoint /me
        $response = $this->actingAs($user)->getJson('/me');

        // 3. Assert: Pastikan id user yang dikembalikan cocok
        $response->assertStatus(200)
                 ->assertJsonPath('user.id', $user->id);
    }

    public function test_user_can_logout()
    {
        // 1. Setup: Buat data user
        $user = User::factory()->create(['warung_id' => 1]);

        // 2. Action: Login (actingAs) lalu hit endpoint /logout
        $response = $this->actingAs($user)->postJson('/logout');

        // 3. Assert: Pastikan terlogout (Guest) dan session diretas
        $response->assertStatus(200)
                 ->assertJsonPath('message', 'Logout berhasil');
                 
        $this->assertGuest();
    }
}
