<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->softDeletes("deleted_at");
            $table->timestamps();
        });


        DB::statement("CREATE TRIGGER update_cmr_trigger AFTER UPDATE
           ON cmrs FOR EACH ROW
           BEGIN

           if OLD.title != NEW.title then
             INSERT INTO logs(table_name, column_name, primary_key, old_value, new_value, action, changed_by, created_at, updated_at)
             VALUES('cmrs', 'title', OLD.id, OLD.title, NEW.title, 'UPDATE', NEW.changed_by, NOW(), NOW());
           end if ;

      if OLD.description != NEW.description then
             INSERT INTO logs(table_name, column_name, primary_key, old_value, new_value, action, changed_by, created_at, updated_at)
             VALUES('cmrs', 'description', OLD.id, OLD.description, NEW.description, 'UPDATE', NEW.changed_by, NOW(), NOW());
           end if ;
      if OLD.status != NEW.status then
             INSERT INTO logs(table_name, column_name, primary_key, old_value, new_value, action, changed_by, created_at, updated_at)
             VALUES('cmrs', 'status', OLD.id, OLD.status, NEW.status, 'UPDATE', NEW.changed_by, NOW(), NOW());
           end if ;
      if OLD.request_date != NEW.request_date then
             INSERT INTO logs(table_name, column_name, primary_key, old_value, new_value, action, changed_by, created_at, updated_at)
             VALUES('cmrs', 'request_date', OLD.id, OLD.request_date, NEW.request_date, 'UPDATE', NEW.changed_by, NOW(), NOW());
           end if ;
      if OLD.current_level != NEW.current_level then
             INSERT INTO logs(table_name, column_name, primary_key, old_value, new_value, action, changed_by, created_at, updated_at)
             VALUES('cmrs', 'current_level', OLD.id, OLD.current_level, NEW.current_level, 'UPDATE', NEW.changed_by, NOW(), NOW());
           end if ;

           END;
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cmrs');
    }
};
