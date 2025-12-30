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
        Schema::create('cve_queries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            // OpenCVE API parameters (all nullable as they're optional filters)
            $table->string('search')->nullable();
            $table->string('vendor')->nullable();
            $table->string('product')->nullable();
            $table->string('weakness')->nullable();
            $table->string('tag')->nullable();

            // CVSS threshold configuration
            $table->decimal('cvss_threshold', 3, 1)->default(7.0);

            // Notification configuration
            $table->json('notification_emails');

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cve_queries');
    }
};
