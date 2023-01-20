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
        Schema::create('tbl_examination_room_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_exam')->foreign('id_exam')->references('id')->on('tbl_exam_master')->onDelete('cascade');
            $table->uuid('id_room')->foreign('id_room')->references('id')->on('tbl_room_master')->onDelete('cascade');
            $table->Integer('student_count')->nullable();
            $table->String('internal_invigilator')->nullable();
            $table->String('external_invigilator')->nullable();
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
        Schema::dropIfExists('tbl_examination_room_settings');
    }
};
