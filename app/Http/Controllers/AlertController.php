<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\SoarAlert;
use Carbon\Carbon;

class AlertController extends Controller
{
    public function index()
    {
        // 1. Ambil Data dari Database
        // Mengambil semua alert, diurutkan berdasarkan waktu serangan terbaru
        $allAlerts = SoarAlert::orderBy('attack_time', 'desc')->get();

        // 2. Kelompokkan Data Berdasarkan Domain
        // Hasilnya adalah Collection yang dikelompokkan: ['domain1' => [Alert, Alert], 'domain2' => [Alert]]
        $alertsByDomain = $allAlerts->groupBy('domain');

        // 3. Kirim Data ke View
        return view('dashboard', [
            'alertsByDomain' => $alertsByDomain,
        ]);
    }
}
