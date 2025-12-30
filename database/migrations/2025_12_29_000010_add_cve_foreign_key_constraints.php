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
        Schema::table('application_cve_query', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications');
            $table->foreignId('cve_query_id')->constrained('cve_queries');
        });

        Schema::table('cve_notifications', function (Blueprint $table) {
            $table->foreignId('cve_query_id')->constrained('cve_queries');
            // Add composite index for deduplication
            $table->index(['cve_query_id', 'cve_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_cve_query', function (Blueprint $table) {
            $table->dropForeign(['application_id']);
            $table->dropForeign(['cve_query_id']);
            $table->dropColumn(['application_id', 'cve_query_id']);
        });

        Schema::table('cve_notifications', function (Blueprint $table) {
            $table->dropForeign(['cve_query_id']);
            $table->dropIndex(['cve_query_id', 'cve_id']);
            $table->dropColumn('cve_query_id');
        });
    }
};
