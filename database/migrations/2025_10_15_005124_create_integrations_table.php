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
        Schema::disableForeignKeyConstraints();

        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained();
            $table->foreignId('integrates_with_id')->constrained('applications');
            $table->text('description')->nullable();
            $table->string('protocol')->nullable();
            $table->enum('direction', ["sync","inbound","outbound"]);
            $table->enum('frequency', ["realtime","daily","weekly","monthly","yearly"]);
            $table->text('security')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
