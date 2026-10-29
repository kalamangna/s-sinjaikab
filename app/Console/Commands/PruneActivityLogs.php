<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

class PruneActivityLogs extends Command
{
    /**
     * Nama dan tanda tangan perintah console.
     *
     * @var string
     */
    protected $signature = 'logs:prune {--days=30 : Batas hari penyimpanan log}';

    /**
     * Deskripsi perintah console.
     *
     * @var string
     */
    protected $description = 'Membersihkan data log aktivitas yang melebihi batas hari retensi.';

    /**
     * Jalankan perintah console.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');
        if ($days <= 0) {
            $days = 30;
        }

        $deleted = ActivityLog::pruneOlderThan($days);

        $this->info("Berhasil membersihkan {$deleted} data log aktivitas yang lebih lama dari {$days} hari.");

        return Command::SUCCESS;
    }
}
