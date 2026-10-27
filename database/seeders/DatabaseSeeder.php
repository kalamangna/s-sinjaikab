<?php

namespace Database\Seeders;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@sinjaikab.go.id'],
            [
                'name' => 'Administrator Diskominfo',
                'password' => Hash::make('sinjai2026!'),
                'role' => 'admin',
                'department' => 'Dinas Komunikasi Informatika dan Persandian',
                'is_active' => true,
            ]
        );

        $disdik = User::firstOrCreate(
            ['email' => 'disdik@sinjaikab.go.id'],
            [
                'name' => 'Operator Disdik',
                'password' => Hash::make('disdik2026!'),
                'role' => 'opd',
                'department' => 'Dinas Pendidikan',
                'is_active' => true,
            ]
        );

        $dinkes = User::firstOrCreate(
            ['email' => 'dinkes@sinjaikab.go.id'],
            [
                'name' => 'Operator Dinkes',
                'password' => Hash::make('dinkes2026!'),
                'role' => 'opd',
                'department' => 'Dinas Kesehatan',
                'is_active' => true,
            ]
        );

        ShortUrl::firstOrCreate(
            ['short_code' => 'portal'],
            [
                'user_id' => $admin->id,
                'title' => 'Portal Resmi Pemerintah Kabupaten Sinjai',
                'original_url' => 'https://sinjaikab.go.id',
                'clicks_count' => 0,
                'is_active' => true,
            ]
        );

        ShortUrl::firstOrCreate(
            ['short_code' => 'csirt'],
            [
                'user_id' => $admin->id,
                'title' => 'Portal Resmi SinjaiKab-CSIRT',
                'original_url' => 'https://csirt.sinjaikab.go.id',
                'clicks_count' => 0,
                'is_active' => true,
            ]
        );
    }
}
