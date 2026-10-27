<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Masuk Layanan Tautan Sinjaikab');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@sinjaikab.go.id',
            'password' => bcrypt('password123'),
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'operator@sinjaikab.go.id',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    public function test_inactive_users_cannot_authenticate(): void
    {
        $user = User::factory()->create([
            'email' => 'nonaktif@sinjaikab.go.id',
            'password' => bcrypt('password123'),
            'is_active' => false,
        ]);

        $response = $this->post('/login', [
            'email' => 'nonaktif@sinjaikab.go.id',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
