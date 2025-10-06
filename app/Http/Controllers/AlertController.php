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
}
