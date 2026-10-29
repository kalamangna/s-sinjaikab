<?php

namespace App\Services;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    /**
     * Path to the official Kabupaten Sinjai logo image.
     */
    protected string $logoPath;

    public function __construct(?string $logoPath = null)
    {
        $this->logoPath = $logoPath ?? public_path('images/logo-sinjai.png');
    }

    /**
     * Generate an SVG QR code embedded with the official Sinjai logo in the center.
     */
    public function generateSvg(string $targetUrl, int $size = 400): string
    {
        $svg = (string) QrCode::size($size)->errorCorrection('H')->generate($targetUrl);

        if (! file_exists($this->logoPath)) {
            return $svg;
        }

        $logoData = base64_encode((string) file_get_contents($this->logoPath));
        $logoInfo = @getimagesize($this->logoPath);
        $origW = $logoInfo ? (int) $logoInfo[0] : 1;
        $origH = $logoInfo ? (int) $logoInfo[1] : 1;

        // Center badge and logo sizing (around 22% of total size)
        $badgeSize = (int) round($size * 0.22);
        $badgeX = (int) round(($size - $badgeSize) / 2);
        $badgeY = (int) round(($size - $badgeSize) / 2);
        $badgeRadius = max(6, (int) round($badgeSize * 0.16));

        $maxLogoW = (int) round($badgeSize * 0.86);
        $maxLogoH = (int) round($badgeSize * 0.86);
        $ratio = min($maxLogoW / $origW, $maxLogoH / $origH);

        $logoW = (int) round($origW * $ratio);
        $logoH = (int) round($origH * $ratio);
        $logoX = (int) round(($size - $logoW) / 2);
        $logoY = (int) round(($size - $logoH) / 2);

        $centerElements = "<g id='sinjai-qr-center'>" .
            "<rect x='{$badgeX}' y='{$badgeY}' width='{$badgeSize}' height='{$badgeSize}' rx='{$badgeRadius}' fill='#ffffff' stroke='#e2e8f0' stroke-width='1.5' />" .
            "<image href='data:image/png;base64,{$logoData}' x='{$logoX}' y='{$logoY}' width='{$logoW}' height='{$logoH}' preserveAspectRatio='xMidYMid meet' />" .
            "</g>";

        return str_replace('</svg>', $centerElements . '</svg>', $svg);
    }

    /**
     * Generate a high-resolution PNG QR code embedded with the official Sinjai logo via GD.
     */
    public function generatePng(string $targetUrl, int $size = 1000): string
    {
        $qr = Encoder::encode($targetUrl, ErrorCorrectionLevel::H());
        $matrix = $qr->getMatrix();
        $matrixWidth = $matrix->getWidth();
        $matrixHeight = $matrix->getHeight();

        $margin = 4; // Quiet zone in modules
        $totalModules = $matrixWidth + ($margin * 2);
        $moduleSize = $size / $totalModules;

        $img = imagecreatetruecolor($size, $size);
        $white = imagecolorallocate($img, 255, 255, 255);
        $dark = imagecolorallocate($img, 15, 23, 42); // slate-900

        imagefill($img, 0, 0, $white);

        // Draw QR modules
        for ($y = 0; $y < $matrixHeight; $y++) {
            for ($x = 0; $x < $matrixWidth; $x++) {
                if ($matrix->get($x, $y) === 1) {
                    $x1 = (int) round(($x + $margin) * $moduleSize);
                    $y1 = (int) round(($y + $margin) * $moduleSize);
                    $x2 = (int) round(($x + $margin + 1) * $moduleSize);
                    $y2 = (int) round(($y + $margin + 1) * $moduleSize);
                    imagefilledrectangle($img, $x1, $y1, $x2, $y2, $dark);
                }
            }
        }

        // Draw center logo badge if logo exists
        if (file_exists($this->logoPath)) {
            $badgeSize = (int) round($size * 0.22);
            $badgeX = (int) round(($size - $badgeSize) / 2);
            $badgeY = (int) round(($size - $badgeSize) / 2);
            $borderColor = imagecolorallocate($img, 226, 232, 240); // slate-200

            imagefilledrectangle($img, $badgeX, $badgeY, $badgeX + $badgeSize, $badgeY + $badgeSize, $white);
            imagerectangle($img, $badgeX, $badgeY, $badgeX + $badgeSize, $badgeY + $badgeSize, $borderColor);

            $logoImg = imagecreatefrompng($this->logoPath);
            if ($logoImg !== false) {
                imagealphablending($logoImg, true);
                $origW = imagesx($logoImg);
                $origH = imagesy($logoImg);

                $maxLogoW = (int) round($badgeSize * 0.86);
                $maxLogoH = (int) round($badgeSize * 0.86);
                $ratio = min($maxLogoW / $origW, $maxLogoH / $origH);

                $targetLogoW = (int) round($origW * $ratio);
                $targetLogoH = (int) round($origH * $ratio);
                $targetLogoX = (int) round(($size - $targetLogoW) / 2);
                $targetLogoY = (int) round(($size - $targetLogoH) / 2);

                imagecopyresampled(
                    $img,
                    $logoImg,
                    $targetLogoX,
                    $targetLogoY,
                    0,
                    0,
                    $targetLogoW,
                    $targetLogoH,
                    $origW,
                    $origH
                );
            }
        }

        ob_start();
        imagepng($img);
        $pngData = (string) ob_get_clean();

        return $pngData;
    }
}
