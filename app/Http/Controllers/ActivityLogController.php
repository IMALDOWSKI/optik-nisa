<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter user
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter modul
        if ($request->modul) {
            $query->where('modul', $request->modul);
        }

        // Filter aksi
        if ($request->aksi) {
            $query->where('aksi', $request->aksi);
        }

        // Filter tanggal
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $logs   = $query->paginate(20);
        $users  = User::all();
        $moduls = ActivityLog::select('modul')->distinct()->pluck('modul');

        return view('activity_log.index', compact('logs', 'users', 'moduls'));
    }

    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');
        return view('activity_log.show', compact('activityLog'));
    }

    public function hapusLama()
    {
        // Hapus log lebih dari 30 hari
        ActivityLog::where('created_at', '<', Carbon::now()->subDays(30))->delete();
        return redirect()->route('activity-log.index')
                         ->with('success', 'Log lama berhasil dihapus!');
    }
}