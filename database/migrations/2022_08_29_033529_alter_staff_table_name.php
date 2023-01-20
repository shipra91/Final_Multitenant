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
        Schema::table('tbl_staff', function (Blueprint $table) {
            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade')->after('id');
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade')->after('id');
            $table->String('district')->after('state');
            $table->String('taluk')->after('district');
            $table->String('post_office')->after('pincode');
            $table->String('head_teacher')->after('attachment_pancard')->nullable();
            $table->String('working_hours')->after('head_teacher');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_staff', function (Blueprint $table) {
            $table->dropColumn('id_institute');
            $table->dropColumn('id_academic_year');
            $table->dropColumn('district');
            $table->dropColumn('taluk');
            $table->dropColumn('post_office');
            $table->dropColumn('head_teacher');
            $table->dropColumn('working_hours');
        });
    }
};
