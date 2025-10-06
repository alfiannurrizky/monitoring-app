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
        $allAlerts = SoarAlert::orderBy('attack_time', 'desc')->get();

        $alertsByDomain = $allAlerts->groupBy('domain');

        return view('dashboard.detail_table', [
            'alertsByDomain' => $alertsByDomain,
        ]);
    }

    public function destroy(SoarAlert $alert)
    {
        try {
            $alert->delete();
            return redirect()->route('alerts.detail')->with('success', 'Alert berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('alerts.detail')->with('error', 'Gagal menghapus alert: ' . $e->getMessage());
        }
    }
}
