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
        Schema::create('tbl_exam_timetable', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->String('id_exam_timetable_setting')->foreign('id_exam_timetable_setting')->references('id')->on('tbl_exam_timetable_setting')->onDelete('cascade');
            $table->String('id_subject');
            $table->date('exam_date');
            $table->Integer('duration_in_min');
            $table->String('start_time');
            $table->String('end_time');
            $table->Integer('max_marks');
            $table->Integer('min_marks');
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
        Schema::dropIfExists('tbl_exam_timetable');
    }
};
