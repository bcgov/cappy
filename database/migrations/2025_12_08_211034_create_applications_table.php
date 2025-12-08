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
            $table->string('ministry');
            $table->string('division')->nullable();
            $table->string('business_owner_name');
            $table->string('business_owner_email');
            $table->string('technical_contact_name');
            $table->string('technical_contact_email');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->string('hosting_type')->nullable();
            $table->string('hosting_details')->nullable();
            $table->string('documentation_url')->nullable();
            $table->string('repository_url')->nullable();
            $table->date('go_live_date')->nullable();
            $table->date('end_of_life_date')->nullable();
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
