<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(array $attributes = [])
    {
        $warung = \App\Models\Warung::create();
        return User::factory()->create(array_merge(['warung_id' => $warung->id], $attributes));
    }

    public function test_profile_page_is_displayed(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'Test User Updated',
            'email' => 'test_updated@example.com',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $user->refresh();

        $this->assertSame('Test User Updated', $user->name);
        $this->assertSame('test_updated@example.com', $user->email);
    }

    public function test_password_can_be_updated(): void
    {
        $user = $this->createUser([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->put('/profile/password', [
            'current_password' => 'password123',
            'new_password' => 'new-password',
            'new_password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = $this->createUser([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->put('/profile/password', [
            'current_password' => 'wrong-password',
            'new_password' => 'new-password',
            'new_password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors('current_password');
        
        $this->assertTrue(Hash::check('password123', $user->refresh()->password));
    }
}
