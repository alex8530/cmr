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
        Schema::create('cmrs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->enum('status',['pending','complete'])->default('pending');
            $table->string('request_date');
            // $table->string('report_file')->nullable();
            $table->string('last_version_file_track_id')->nullable();
            // $table->string('assign_user_1_id')->nullable();
            // $table->string('assign_user_2_id')->nullable();
            // $table->string('assign_user_3_id')->nullable();
            // $table->string('assign_user_4_id')->nullable();
            $table->string('owner_id');
            $table->string('changed_by');
            $table->string('current_level')->default("1");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cmrs');
    }
};
