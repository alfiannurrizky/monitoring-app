<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\SoarAlert;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

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
        if (!Auth::user() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Anda tidak punya izin untuk menghapus data ini.');
        }

        try {
            $alert->delete();

            toast('Penghapusan Berhasil', 'success');
            return redirect()->route('alerts.detail');


        } catch (\Exception $e) {
            return redirect()->route('alerts.detail')->with('error', 'Gagal menghapus alert: ' . $e->getMessage());
        }
    }
}
