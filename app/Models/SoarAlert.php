<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoarAlert extends Model
{
    protected $fillable = [
        'domain',
        'alert_title',
        'attack_path',
        'gemini_recommendation',
        'attack_time',
        'severity_level',
        'wazuh_rule_id',
        'raw_wazuh_data',
    ];

    protected $casts = [
        'raw_wazuh_data' => 'array',
        'attack_time' => 'datetime',
        'severity_level' => 'integer',
    ];
}
