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
        Schema::table('applications', function (Blueprint $table) {
            $table->foreignId('ministry_id')
                ->nullable()
                ->constrained('ministries')
                ->nullOnDelete();
        });

        Schema::table('dependencies', function (Blueprint $table) {
            $table->foreignId('supporting_application_id')->constrained('applications');
            $table->foreignId('depending_application_id')->constrained('applications');
        });

        Schema::table('components', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained();
            $table->foreignId('component_of_id')->constrained('applications');
        });

        Schema::table('integrations', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained();
            $table->foreignId('integrates_with_id')->constrained('applications');
        });

        Schema::table('application_users', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained();
            $table->foreignId('application_user_type_id')->constrained('application_user_types');
        });

        Schema::table('vendor_supports', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained();
            $table->foreignId('STOB60_id')->constrained('s_t_o_b60_s');
        });

        Schema::table('staffings', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained();
            $table->foreignId('STOB50_id')->constrained('s_t_o_b50_s');
        });

        Schema::table('application_documentation', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained();
            $table->foreignId('documentation_id')->constrained('documentations');
        });

        Schema::table('vendor_relationships', function (Blueprint $table) {
            $table->foreignId('vendor_id')->constrained();
            $table->foreignId('application_id')->constrained();
            $table->foreignId('contract_id')->constrained();
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->foreignId('vendor_id')->constrained();
        });

        Schema::table('s_t_o_b60_s', function (Blueprint $table) {
            $table->foreignId('vendor_id')->constrained('vendors');
        });

        Schema::table('application_versions', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications');
        });

        Schema::table('application_user_types', function (Blueprint $table) {
            $table->foreignId('business_area_id')->constrained('business_areas');
        });

        Schema::table('application_s_t_o_b50', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications');
            $table->foreignId('s_t_o_b50_id')->constrained('s_t_o_b50_s');
        });

        Schema::table('application_s_t_o_b60', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications');
            $table->foreignId('s_t_o_b60_id')->constrained('s_t_o_b60_s');
        });

        Schema::table('application_subject_matter_expert', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained();
            $table->foreignId('subject_matter_expert_id')->constrained('subject_matter_experts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // It's not recommended to drop foreign keys in a single migration
        // as it can be complex to manage the order.
        // It's better to handle this in each individual migration's down method.
    }
};
