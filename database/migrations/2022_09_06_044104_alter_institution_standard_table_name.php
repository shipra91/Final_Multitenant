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
        Schema::table('tbl_institution_standard', function (Blueprint $table) {
            $table->dropColumn('class_teacher_required');
            $table->dropColumn('id_class_teacher');
            $table->dropColumn('elective_required');
            $table->String('id_course')->after('id_board')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_institution_standard', function (Blueprint $table) {
           $table->dropColumn('class_teacher_required');
           $table->dropColumn('id_class_teacher');
           $table->dropColumn('elective_required');
           $table->dropColumn('id_course');
        });
    }
};
