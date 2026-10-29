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
        // 1 akun lokal administrator utama: kalamangna
        $admin = User::updateOrCreate(
            ['username' => 'kalamangna'],
            [
                'name' => 'kalamangna',
                'password' => Hash::make('Syazani'),
                'role' => 'admin',
                'department' => null,
                'is_active' => true,
            ]
        );

        // Hapus akun contoh dummy lama bila ada
        User::whereIn('username', [
            'admin',
            'disdik',
            'dinkes',
        ])->delete();

        // Tautan awal bawaan
        ShortUrl::updateOrCreate(
            ['short_code' => 'portal'],
            [
                'user_id' => $admin->id,
                'title' => 'Portal Resmi Pemerintah Kabupaten Sinjai',
                'original_url' => 'https://sinjaikab.go.id',
                'clicks_count' => 0,
                'is_active' => true,
            ]
        );

        ShortUrl::updateOrCreate(
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
