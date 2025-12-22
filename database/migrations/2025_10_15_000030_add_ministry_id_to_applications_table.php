<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->foreignId('ministry_id')
                ->nullable()
                ->constrained('ministries')
                ->nullOnDelete();
            $table->dropColumn('ministry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['ministry_id']);
            $table->dropColumn('ministry_id');
            $table->string('ministry')->nullable();
        });
    }
};
