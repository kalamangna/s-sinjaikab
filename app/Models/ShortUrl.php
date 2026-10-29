<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShortUrl extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'original_url',
        'short_code',
        'clicks_count',
        'is_active',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'full_url',
        'display_short_url',
        'display_original_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'clicks_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the short url.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set short_code preserving the user's input casing while trimming whitespace.
     */
    public function setShortCodeAttribute(?string $value): void
    {
        $this->attributes['short_code'] = $value !== null ? trim($value) : null;
    }

    /**
     * Get the full short URL string.
     */
    public function getFullUrlAttribute(): string
    {
        return url('/'.$this->short_code);
    }

    /**
     * Get the display short URL without protocol prefix.
     */
    public function getDisplayShortUrlAttribute(): string
    {
        return preg_replace('#^https?://#', '', $this->full_url);
    }

    /**
     * Get the display destination URL without protocol prefix.
     */
    public function getDisplayOriginalUrlAttribute(): string
    {
        return preg_replace('#^https?://#', '', $this->original_url);
    }
}
