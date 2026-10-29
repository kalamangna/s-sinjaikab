<?php

namespace Tests\Feature;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('s.sinjaikab.go.id');
    }

    public function test_short_url_redirects_and_increments_clicks_count(): void
    {
        $user = User::factory()->create([
            'role' => 'opd',
            'department' => 'Dinas Pendidikan',
        ]);

        $shortUrl = ShortUrl::create([
            'user_id' => $user->id,
            'title' => 'Portal Berita Sinjai',
            'original_url' => 'https://sinjaikab.go.id/v2/berita',
            'short_code' => 'sinjai-news',
            'clicks_count' => 0,
            'is_active' => true,
        ]);

        $response = $this->get('/sinjai-news');

        $response->assertStatus(302);
        $response->assertRedirect('https://sinjaikab.go.id/v2/berita');

        $this->assertEquals(1, $shortUrl->fresh()->clicks_count);
    }

    public function test_inactive_short_url_returns_404(): void
    {
        $shortUrl = ShortUrl::create([
            'title' => 'Tautan Nonaktif',
            'original_url' => 'https://sinjaikab.go.id',
            'short_code' => 'nonaktif',
            'clicks_count' => 0,
            'is_active' => false,
        ]);

        $response = $this->get('/nonaktif');
        $response->assertStatus(404);
        $response->assertSee('Link Tidak Ditemukan');
    }

    public function test_opd_can_create_valid_short_url(): void
    {
        $user = User::factory()->create([
            'role' => 'opd',
            'department' => 'Dinas Kesehatan',
        ]);

        $response = $this->actingAs($user)->post('/urls', [
            'title' => 'Layanan Puskesmas',
            'original_url' => 'https://dinkes.sinjaikab.go.id/layanan',
            'short_code' => 'puskesmas',
        ]);

        $response->assertRedirect('/urls');
        $this->assertDatabaseHas('short_urls', [
            'title' => 'Layanan Puskesmas',
            'short_code' => 'puskesmas',
            'user_id' => $user->id,
        ]);
    }

    public function test_url_with_dangerous_extension_is_rejected(): void
    {
        $user = User::factory()->create(['role' => 'opd']);

        $response = $this->actingAs($user)->from('/urls')->post('/urls', [
            'title' => 'Program Bahaya',
            'original_url' => 'https://example.com/software/installer.exe',
            'short_code' => 'virus',
        ]);

        $response->assertSessionHasErrors(['original_url']);
        $this->assertDatabaseMissing('short_urls', [
            'short_code' => 'virus',
        ]);
    }

    public function test_self_redirection_is_rejected(): void
    {
        $user = User::factory()->create(['role' => 'opd']);

        $response = $this->actingAs($user)->from('/urls')->post('/urls', [
            'title' => 'Loop Tautan',
            'original_url' => 'https://s.sinjaikab.go.id/loop',
            'short_code' => 'loop',
        ]);

        $response->assertSessionHasErrors(['original_url']);
    }

    public function test_qr_code_can_be_generated(): void
    {
        $user = User::factory()->create(['role' => 'opd']);

        $shortUrl = ShortUrl::create([
            'user_id' => $user->id,
            'title' => 'Portal Sinjai',
            'original_url' => 'https://sinjaikab.go.id',
            'short_code' => 'portal-qr',
            'clicks_count' => 0,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get("/urls/{$shortUrl->id}/qr");
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/svg+xml');
    }
}
