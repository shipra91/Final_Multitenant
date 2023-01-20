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
        Schema::table('tbl_exam_timetable', function (Blueprint $table) {
            $table->renameColumn('id_subject','id_institution_subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_exam_timetable', function (Blueprint $table) {
            $table->renameColumn('id_subject','id_institution_subject');
        });
    }
};
