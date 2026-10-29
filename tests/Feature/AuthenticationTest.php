<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login Akun ENIKDA');
    }

    public function test_kalamangna_local_admin_can_authenticate(): void
    {
        User::create([
            'username' => 'kalamangna',
            'name' => 'kalamangna',
            'password' => bcrypt('Syazani'),
            'role' => 'admin',
            'department' => 'Dinas Komunikasi Informatika dan Persandian',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'identifier' => 'kalamangna',
            'password' => 'Syazani',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/urls');
        $this->assertTrue(auth()->user()->isAdmin());
    }

    public function test_users_can_authenticate_via_local_username(): void
    {
        $user = User::factory()->create([
            'username' => 'operator_sinjai',
            'password' => bcrypt('password123'),
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'identifier' => 'operator_sinjai',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/urls');
    }

    public function test_users_can_authenticate_via_enikda_gateway(): void
    {
        $nip = '198801012011011001';

        Http::fake([
            '*user_auth*' => Http::response('1', 200),
            '*data_pegawai*' => Http::response([
                'nama' => 'Ahmad Pegawai Sinjai',
                'nip' => $nip,
                'unit_id' => '12',
            ], 200),
            '*get_unit*' => Http::response([
                'unit_nama' => 'Dinas Pendidikan',
            ], 200),
        ]);

        $response = $this->post('/login', [
            'identifier' => $nip,
            'password' => 'secret123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/urls');

        $this->assertDatabaseHas('users', [
            'nip' => $nip,
            'name' => 'Ahmad Pegawai Sinjai',
            'department' => 'Dinas Pendidikan',
            'role' => 'user',
        ]);
    }

    public function test_inactive_users_cannot_authenticate(): void
    {
        $user = User::factory()->create([
            'username' => 'nonaktif',
            'password' => bcrypt('password123'),
            'is_active' => false,
        ]);

        $response = $this->post('/login', [
            'identifier' => 'nonaktif',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['identifier']);
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
