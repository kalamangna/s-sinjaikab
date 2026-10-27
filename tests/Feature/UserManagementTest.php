<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_user_management(): void
    {
        $opd = User::factory()->create([
            'role' => 'opd',
        ]);

        $response = $this->actingAs($opd)->get('/users');
        $response->assertStatus(403);
    }

    public function test_admin_can_view_user_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/users');
        $response->assertStatus(200);
        $response->assertSee('Kelola Akun OPD');
    }

    public function test_admin_can_create_opd_user(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/users', [
            'name' => 'Operator Dispora',
            'email' => 'dispora@sinjaikab.go.id',
            'department' => 'Dinas Pemuda dan Olahraga',
            'password' => 'dispora2026!',
        ]);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', [
            'email' => 'dispora@sinjaikab.go.id',
            'department' => 'Dinas Pemuda dan Olahraga',
            'role' => 'opd',
        ]);
    }
}
