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
        Schema::create('cmr_requests', function (Blueprint $table) {
            $table->id();
            $table->string('cmr_id');
            $table->string('user_id');
            $table->string('level');
            $table->string('comment')->nullable();
            $table->enum ('status',['in_progress','pending','rejected','approved'])->default('pending');
            // $table->string('report_file')->nullable();
            $table->string('file_track_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cmr_requests');
    }
};
