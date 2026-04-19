<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MoodEntry;
use App\Models\SupportMessage;
use App\Models\SystemUsage;
use App\Models\EmailReminder;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'mood_entries_today' => MoodEntry::whereDate('created_at', now()->today())->count(),
            'open_tickets' => SupportMessage::where('status', 'open')->count(),
            'visitors_today' => SystemUsage::whereDate('created_at', now()->today())->count(),
        ];

        // Mood distribution for charts
        $moodDistribution = MoodEntry::select('mood', DB::raw('count(*) as count'))
            ->groupBy('mood')
            ->get();

        // System activity last 7 days
        $activityTrend = SystemUsage::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact('stats', 'moodDistribution', 'activityTrend'));
    }

    public function metrics(Request $request)
    {
        // Automatically log the admin's access
        SystemUsage::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'action' => 'Accessed System Metrics Dashboard',
            'device_info' => $request->userAgent()
        ]);

        $logs = SystemUsage::with('user')->orderBy('created_at', 'desc')->paginate(50);
        $notifications = EmailReminder::with('user')->orderBy('created_at', 'desc')->paginate(50);

        return view('admin.system.metrics', compact('logs', 'notifications'));
    }
}
