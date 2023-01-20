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
        Schema::table('tbl_exam_subject_configuration', function (Blueprint $table) {
            $table->uuid('id_grade_set')->foreign('id_grade_set')->references('id')->on('tbl_exam_subject_configuration')->onDelete('cascade')->after('id_subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_exam_subject_configuration', function (Blueprint $table) {
            $table->dropColumn(['id_grade_set']);
        });
    }
};
