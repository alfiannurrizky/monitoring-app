<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('soar_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->index();
            $table->string('alert_title', 500);
            $table->text('attack_path');
            $table->text('gemini_recommendation');
            $table->timestamp('attack_time')->index();
            $table->integer('severity_level')->index(); // Level Wazuh (e.g., 7)
            $table->string('wazuh_rule_id')->nullable();
            $table->json('raw_wazuh_data')->nullable(); // Payload mentah untuk forensik

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soar_alerts');
    }
};
