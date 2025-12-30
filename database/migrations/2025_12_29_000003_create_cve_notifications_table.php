<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cve_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('cve_id');

            // Full CVE data snapshot (JSON blob for reference)
            $table->json('cve_data');

            // Notification tracking
            $table->json('notified_emails');
            $table->timestamp('notified_at');

            $table->timestamps();

            // Index for deduplication lookups
            $table->index('cve_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cve_notifications');
    }
};
