<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AlertController extends Controller
{
    public function index()
    {
        // --- DUMMY DATA HARDCODE ---
        $dummyAlerts = [
            [
                'domain' => 'example.ut.ac.id',
                'attack_time' => now()->subMinutes(15)->toDateTimeString(),
                'alert_title' => 'SQL Injection Attempt (Level 12)',
                'attack_path' => '/login.php?user_id=1%20union%20select%201,2,database()--',
                'gemini_recommendation' => 'Segera terapkan Web Application Firewall (WAF) dan pastikan semua input pengguna divalidasi dan menggunakan prepared statements di sisi backend (PHP). Patching framework segera.',
            ],
            [
                'domain' => 'example.ut.ac.id',
                'attack_time' => now()->subHours(2)->toDateTimeString(),
                'alert_title' => 'Multiple Path Traversal Attempts (Level 7)',
                'attack_path' => '/image.php?file=../../../../etc/passwd',
                'gemini_recommendation' => 'Pastikan konfigurasi web server (Nginx/Apache) Anda memblokir karakter direktori traversal (`../`) dan gunakan fungsi path resolver yang aman di aplikasi (e.g., `realpath()` di PHP).',
            ],
            [
                'domain' => 'example2.ut.ac.id',
                'attack_time' => now()->subMinutes(5)->toDateTimeString(),
                'alert_title' => 'Cross Site Scripting (XSS) via GET Parameter (Level 9)',
                'attack_path' => '/search.php?q=<script>alert(document.cookie)</script>',
                'gemini_recommendation' => 'Lakukan sanitasi dan encoding (HTML entity encoding) pada semua output data yang berasal dari input pengguna sebelum ditampilkan kembali ke halaman web. Gunakan Content Security Policy (CSP).',
            ],
        ];

        // Konversi array ke Collection dan kelompokkan per domain, meniru hasil Eloquent.
        $alertsCollection = new Collection($dummyAlerts);
        $alertsByDomain = $alertsCollection->groupBy('domain');
        // --- AKHIR DUMMY DATA ---

        return view('dashboard', [
            'alertsByDomain' => $alertsByDomain,
        ]);
    }
}
