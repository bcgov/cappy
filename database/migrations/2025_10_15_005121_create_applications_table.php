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
            $table->string('name', 400);
            $table->text('description')->nullable();
            $table->enum('category', ["business","support","data","network","hosting","security","other"]);
            $table->integer('average_daily_users')->nullable();
            $table->integer('annual_cost')->nullable();
            $table->string('cost_function', 400)->nullable();
            $table->integer('cost_per_unit')->nullable();
            $table->text('license_summary')->nullable();
            $table->integer('annual_vendor_cost')->nullable();
            $table->date('initial_deployment')->nullable();
            $table->date('end_of_support')->nullable();
            $table->date('end_of_life')->nullable();
            $table->date('disposition_deadline')->nullable();
            $table->string('disposition_decision', 400)->nullable();
            $table->timestamps();
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
