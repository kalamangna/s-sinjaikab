<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\View\View;

class AdminLogController extends Controller
{
    /**
     * Tampilkan riwayat log aktivitas seluruh pengguna untuk administrator.
     */
    public function index(): View
    {
        $logs = ActivityLog::with('user')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.logs.index', [
            'logs' => $logs,
        ]);
    }
}
