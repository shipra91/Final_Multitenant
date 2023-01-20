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
        Schema::create('tbl_attendance_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->String('attendance_type');
            $table->uuid('id_standard')->foreign('id_standard')->references('id')->on('tbl_institution_standard')->onDelete('cascade');
            $table->uuid('id_template')->foreign('id_template')->references('id')->on('tbl_sms_templates')->onDelete('cascade');
            $table->String('display_subject');
            $table->String('is_subject_classtimetable_dependent');
            $table->String('created_by')->nullable();
            $table->String('modified_by')->nullable();
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
        Schema::dropIfExists('tbl_attendance_settings');
    }
};
