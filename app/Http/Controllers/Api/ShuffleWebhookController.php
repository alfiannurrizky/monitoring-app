<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\SoarAlert;

class ShuffleWebhookController extends Controller
{
    protected $expectedToken;

    // Tambahkan Constructor untuk inisialisasi token
    public function __construct()
    {
        // Token diinisialisasi di sini menggunakan env()
        // Ganti 'fallback_token_jika_kosong' dengan nilai default Anda atau kosongkan.
        $this->expectedToken = env('API_KEY');
    }

    public function handle(Request $request)
    {
        $submittedToken = $request->header('X-API-KEY');

        // 1. Validasi Keamanan (Secret Token)
        if ($submittedToken !== $this->expectedToken) {
            Log::warning('Shuffle Webhook: Unauthorized access attempt via header.', ['ip' => $request->ip(), 'submitted_token' => $submittedToken]);
            return response()->json([
                'status' => 'error',
                'message' => 'Token API di header tidak valid.'
            ], 401);
        }

        // 2. Validasi Data
        $validated = $request->validate([
            'domain' => 'required|string|max:255',
            'alert_title' => 'required|string|max:500',
            'attack_path' => 'required|string',
            'gemini_recommendation' => 'required|string',
            'timestamp' => 'required|date',
            'severity_level' => 'required|integer',
            'wazuh_rule_id' => 'nullable|string',
            'raw_data' => 'nullable|array',
        ]);

        try {
            // 3. Simpan ke Database
            SoarAlert::create([
                'domain' => $validated['domain'],
                'alert_title' => $validated['alert_title'],
                'attack_path' => $validated['attack_path'],
                'gemini_recommendation' => $validated['gemini_recommendation'],
                'attack_time' => $validated['timestamp'],
                'severity_level' => $validated['severity_level'],
                'wazuh_rule_id' => $validated['wazuh_rule_id'] ?? null,
                'raw_wazuh_data' => $validated['raw_data'] ?? null,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Alert diterima dan disimpan.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Shuffle Webhook Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data.'
            ], 500);
        }
    }
}
