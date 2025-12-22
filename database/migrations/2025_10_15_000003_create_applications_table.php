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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ministry')->nullable();
            //$table->foreignId('ministry_id')->nullable()->constrained('ministries')->nullOnDelete();
            $table->string('division')->nullable();
            $table->string('business_owner_name')->nullable();
            $table->string('business_owner_email')->nullable();
            $table->string('technical_contact_name')->nullable();
            $table->string('technical_contact_email')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->string('hosting_type')->nullable();
            $table->string('hosting_details')->nullable();
            $table->string('documentation_url')->nullable();
            $table->string('repository_url')->nullable();
            $table->date('go_live_date')->nullable();
            $table->date('end_of_life_date')->nullable();
            $table->enum('category', ["business","support","data","network","hosting","security","other"]);
            $table->integer('average_daily_users')->nullable();
            $table->integer('annual_cost')->nullable();
            $table->string('cost_function', 400)->nullable();
            $table->integer('cost_per_unit')->nullable();
            $table->text('license_summary')->nullable();
            $table->integer('annual_vendor_cost')->nullable();
            $table->date('initial_deployment')->nullable();
            $table->date('end_of_support')->nullable();
            $table->date('disposition_deadline')->nullable();
            $table->string('disposition_decision', 400)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
