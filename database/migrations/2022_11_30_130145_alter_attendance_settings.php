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
        Schema::table('tbl_attendance_settings', function (Blueprint $table) {
            $table->string('display_subject')->nullable()->change();
            $table->string('is_subject_classtimetable_dependent')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_attendance_settings', function (Blueprint $table) {
            $table->dropColumn('display_subject');
            $table->dropColumn('is_subject_classtimetable_dependent');
        });
    }
};
