<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EnikdaGatewayService
{
    protected string $baseUrl;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.enikda.url', 'https://apps.sinjaikab.go.id/api/pegawai');
        $this->timeout = config('services.enikda.timeout', 10);
    }

    /**
     * Determine if an identifier is formatted like a NIP.
     */
    public function isNip(string $identifier): bool
    {
        $clean = trim($identifier);
        return ctype_digit($clean) && strlen($clean) >= 9;
    }

    /**
     * Authenticate employee credentials against ENIKDA / SIMPEG Gateway.
     *
     * @return array{nip: string, name: string, department: string, email: string}|null
     */
    public function authenticate(string $nip, string $password): ?array
    {
        $nip = trim($nip);

        try {
            // 1. Direct auth endpoint
            $authResponse = Http::timeout(min(6, $this->timeout))->get("{$this->baseUrl}/user_auth/", [
                'username' => $nip,
                'password' => $password,
            ]);

            $authBody = trim($authResponse->body());
            $isHtml = str_contains($authBody, '<html') || str_contains($authBody, '<!DOCTYPE') || str_contains($authBody, '<br') || str_contains($authBody, '<h1>');
            $authPassed = (!$isHtml && $authResponse->successful() && !empty($authBody) && $authBody !== '0' && $authBody !== 'false');

            // 2. Fallback via MD5 hash comparison on data_pegawai if user_auth returns non-standard response
            if (!$authPassed && !$authResponse->serverError()) {
                $pegawaiCheck = Http::timeout(min(5, $this->timeout))->get("{$this->baseUrl}/data_pegawai/", [
                    'nip' => $nip,
                ]);

                if ($pegawaiCheck->successful()) {
                    $pCheckData = $pegawaiCheck->json();
                    $pc = $pCheckData['data'] ?? ($pCheckData[0] ?? $pCheckData);
                    if (is_array($pc) && !empty($pc['password']) && strtolower($pc['password']) === md5($password)) {
                        $authPassed = true;
                    }
                }
            }

            if (!$authPassed) {
                return null;
            }

            // 3. Fetch employee profile details
            $pegawaiResponse = Http::timeout(min(5, $this->timeout))->get("{$this->baseUrl}/data_pegawai/", [
                'nip' => $nip,
            ]);

            if (!$pegawaiResponse->successful()) {
                return null;
            }

            $pegawaiData = $pegawaiResponse->json();
            $pData = $pegawaiData['data'] ?? ($pegawaiData[0] ?? $pegawaiData);

            if (!is_array($pData) || empty($pData['nama_pegawai'] ?? $pData['nama'] ?? null)) {
                return null;
            }

            $name = trim((string)($pData['nama_pegawai'] ?? $pData['nama']));
            $unitId = $pData['unit_id'] ?? ($pData['id_unit'] ?? null);
            $department = 'Pemerintah Kabupaten Sinjai';

            if ($unitId) {
                try {
                    $unitResponse = Http::timeout(min(4, $this->timeout))->get("{$this->baseUrl}/get_unit/", [
                        'unit_id' => $unitId,
                    ]);

                    if ($unitResponse->successful()) {
                        $unitData = $unitResponse->json();
                        $uData = $unitData['data'] ?? ($unitData[0] ?? $unitData);
                        $fetchedUnit = $uData['unit_nama'] ?? ($uData['nama_unit'] ?? ($uData['unit_kerja'] ?? null));
                        if (!empty($fetchedUnit)) {
                            $department = trim((string)$fetchedUnit);
                        }
                    }
                } catch (Exception $e) {
                    Log::warning("ENIKDA get_unit error for unit {$unitId}: " . $e->getMessage());
                }
            }

            return [
                'nip' => $nip,
                'name' => $name,
                'department' => $department,
                'email' => "{$nip}@sinjaikab.go.id",
            ];
        } catch (Exception $e) {
            Log::warning("ENIKDA Gateway error for NIP {$nip}: " . $e->getMessage());
            return null;
        }
    }
}
