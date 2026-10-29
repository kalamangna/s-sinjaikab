<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * Disable default updated_at column since logs are append-only.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    /**
     * Relasi log aktivitas ke pengguna.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Catat log aktivitas baru ke basis data.
     */
    public static function record(string $action, string $description, ?User $user = null): static
    {
        $resolvedUser = $user ?? auth()->user();

        return static::create([
            'user_id' => $resolvedUser?->id,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }

    /**
     * Bersihkan log aktivitas yang lebih lama dari jumlah hari tertentu.
     */
    public static function pruneOlderThan(int $days = 30): int
    {
        return static::where('created_at', '<', now()->subDays($days))->delete();
    }

    /**
     * Label aksi yang lugas dan terstandar dalam bahasa Indonesia.
     */
    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'login' => 'Login',
            'logout' => 'Logout',
            'create_url' => 'Tambah Link',
            'update_url' => 'Ubah Link',
            'delete_url' => 'Hapus Link',
            default => ucfirst(str_replace('_', ' ', $this->action)),
        };
    }

    /**
     * Kelas gaya Tailwind untuk lencana status aksi.
     */
    public function getActionBadgeClassAttribute(): string
    {
        return match ($this->action) {
            'login' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20',
            'logout' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-600/20',
            'create_url' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/20',
            'update_url' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20',
            'delete_url' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-600/20',
            default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-600/20',
        };
    }
}
