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
        Schema::create('ministries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Add foreign key to applications table
        Schema::table('applications', function (Blueprint $table) {
            $table->foreignId('ministry_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('ministry');
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['ministry_id']);
            $table->dropColumn('ministry_id');
        });

        Schema::dropIfExists('ministries');

        Schema::table('applications', function (Blueprint $table) {
            $table->string('ministry')->nullable()->after('name');
        });
    }
};
