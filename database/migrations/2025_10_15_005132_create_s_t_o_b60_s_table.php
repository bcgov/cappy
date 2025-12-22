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

        Schema::create('s_t_o_b60_s', function (Blueprint $table) {
            $table->id();
            $table->string('title', 400);
            $table->text('description')->nullable();
            $table->integer('rate')->nullable();
            $table->foreignId('vendor_id');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_t_o_b60_s');
    }
};
