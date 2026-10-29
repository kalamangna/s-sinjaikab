<?php

namespace App\Services;

use App\Models\ShortUrl;
use InvalidArgumentException;

class UrlShortenerService
{
    /**
     * Reserved slugs that cannot be used as short codes.
     */
    protected const RESERVED_SLUGS = [
        'login',
        'logout',
        'dashboard',
        'urls',
        'users',
        'profile',
        'qr',
        'assets',
        'build',
        'api',
        'up',
        'admin',
        'sinjai',
        'csirt',
    ];

    /**
     * Prohibited file extensions for security.
     */
    protected const DANGEROUS_EXTENSIONS = [
        'exe', 'bat', 'cmd', 'sh', 'msi', 'apk', 'vbs', 'ps1', 'scr', 'pif', 'com', 'jar',
    ];

    /**
     * Validate target destination URL.
     *
     * @throws InvalidArgumentException
     */
    public function validateDestinationUrl(string $url, ?string $requestHost = null): void
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('URL tidak valid.');
        }

        $parsed = parse_url($url);
        $scheme = strtolower($parsed['scheme'] ?? '');

        if (! in_array($scheme, ['https', 'http'], true)) {
            throw new InvalidArgumentException('Gunakan protokol http atau https.');
        }

        $host = strtolower($parsed['host'] ?? '');

        // Prevent self-redirection & loopback
        $blockedHosts = [
            's.sinjaikab.go.id',
            'localhost',
            '127.0.0.1',
            '0.0.0.0',
            '::1',
            '[::1]',
        ];

        if ($requestHost) {
            $blockedHosts[] = strtolower($requestHost);
        }

        if (in_array($host, $blockedHosts, true)) {
            throw new InvalidArgumentException('URL tujuan tidak diizinkan.');
        }

        // Prevent internal/private intranet IP ranges (RFC 1918, link-local, cloud metadata)
        $cleanHost = trim($host, '[]');
        if (filter_var($cleanHost, FILTER_VALIDATE_IP)) {
            if (! filter_var($cleanHost, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                throw new InvalidArgumentException('URL jaringan lokal atau privat tidak diizinkan.');
            }
        }

        // Prevent dangerous files
        $path = $parsed['path'] ?? '';
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($extension, self::DANGEROUS_EXTENSIONS, true)) {
            throw new InvalidArgumentException('Tipe berkas dilarang.');
        }
    }

    /**
     * Check if a slug is reserved.
     */
    public function isSlugReserved(string $slug): bool
    {
        return in_array(strtolower($slug), self::RESERVED_SLUGS, true);
    }

    /**
     * Generate a unique random short code.
     */
    public function generateUniqueCode(int $length = 5): string
    {
        // Safe character pool without confusing glyphs (0, O, 1, l, I)
        $characters = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $maxIndex = strlen($characters) - 1;

        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[random_int(0, $maxIndex)];
            }
        } while ($this->isSlugReserved($code) || ShortUrl::where('short_code', $code)->exists());

        return $code;
    }
}
