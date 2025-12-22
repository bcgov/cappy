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

        Schema::create('application_versions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 400);
            $table->date('release')->nullable();
            $table->date('end_of_life')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('application_id');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_versions');
    }
};
