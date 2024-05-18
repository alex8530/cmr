<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('column_name');
            $table->unsignedBigInteger('primary_key');
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->string('action');
            $table->string('changed_by');
            $table->timestamps();
        });


        DB::statement("CREATE TRIGGER update_cmr_trigger AFTER UPDATE
           ON cmrs FOR EACH ROW
           BEGIN
           if OLD.title != NEW.title then
             INSERT INTO logs(table_name, column_name, primary_key, old_value, new_value, action, changed_by, created_at, updated_at)
             VALUES('cmrs', 'title', OLD.id, OLD.title, NEW.title, 'UPDATE', NEW.changed_by, NOW(), NOW());
           end if ;

           END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
