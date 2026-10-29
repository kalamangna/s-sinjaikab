<?php

namespace Tests\Feature;

use App\Console\Commands\PruneActivityLogs;
use App\Models\ActivityLog;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_logs(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/logs');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_logs(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/logs');

        $response->assertStatus(200);
        $response->assertSee('Log Aktivitas');
    }

    public function test_activity_is_logged_on_link_creation(): void
    {
        $user = User::factory()->create(['role' => 'opd']);

        $this->actingAs($user)->post('/urls', [
            'title' => 'Portal Berita',
            'original_url' => 'https://sinjaikab.go.id/berita',
            'short_code' => 'portal-berita',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->id,
            'action' => 'create_url',
        ]);
    }

    public function test_activity_is_logged_on_link_update_and_delete(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $shortUrl = ShortUrl::factory()->create([
            'user_id' => $admin->id,
            'short_code' => 'link-uji',
            'original_url' => 'https://sinjaikab.go.id',
        ]);

        $this->actingAs($admin)->put("/urls/{$shortUrl->id}", [
            'title' => 'Link Baru',
            'original_url' => 'https://sinjaikab.go.id/baru',
            'short_code' => 'link-uji',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'update_url',
        ]);

        $this->actingAs($admin)->delete("/urls/{$shortUrl->id}");

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'delete_url',
        ]);
    }

    public function test_logs_prune_removes_old_logs(): void
    {
        $user = User::factory()->create();

        // Create log older than 30 days
        $oldLog = ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'description' => 'Log lama',
            'ip_address' => '127.0.0.1',
            'created_at' => now()->subDays(35),
        ]);

        // Create fresh log
        $newLog = ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'description' => 'Log baru',
            'ip_address' => '127.0.0.1',
            'created_at' => now()->subDays(2),
        ]);

        $this->artisan('logs:prune', ['--days' => 30])
            ->assertSuccessful();

        $this->assertDatabaseMissing('activity_logs', ['id' => $oldLog->id]);
        $this->assertDatabaseHas('activity_logs', ['id' => $newLog->id]);
    }
}
