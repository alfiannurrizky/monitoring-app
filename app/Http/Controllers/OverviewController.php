<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoarAlert;
use Carbon\Carbon;

class OverviewController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->startOfDay();

        // 1. Total Alerts Hari Ini
        $totalAlertsToday = SoarAlert::where('attack_time', '>=', $today)->count();

        // 2. Top 5 Domain Terdampak Hari Ini
        $topDomains = SoarAlert::selectRaw('domain, COUNT(*) as count')
            ->where('attack_time', '>=', $today)
            ->groupBy('domain')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // 3. Top 5 Jenis Serangan
        $topAttacks = SoarAlert::selectRaw('alert_title, COUNT(*) as count')
            ->where('attack_time', '>=', $today)
            ->groupBy('alert_title')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // 4. Level Serangan Tertinggi
        $maxSeverity = SoarAlert::where('attack_time', '>=', $today)->max('severity_level');

        return view('dashboard.overview', compact('totalAlertsToday', 'topDomains', 'topAttacks', 'maxSeverity'));
    }
}
