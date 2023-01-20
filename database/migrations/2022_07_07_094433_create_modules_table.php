<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_module', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('module_label')->unique();
            $table->string('display_name')->unique();
            $table->uuid('id_parent');
            $table->string('file_path');
            $table->string('icon');
            $table->enum('type', ['Web', 'App']);
            $table->enum('is_custom_field_required', ['No', 'Yes']);
            $table->enum('is_sms_mapped', ['No', 'Yes']);
            $table->enum('is_email_mapped', ['No', 'Yes']);
            $table->enum('access_for', ['institution', 'service', 'developer']);
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_module');
    }
};
