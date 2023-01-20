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
        Schema::table('tbl_examination_room_settings', function (Blueprint $table) {
            $table->String('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade')->after('id');
            $table->String('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade')->after('id');
            $table->String('id_standard')->after('id_exam')->nullable();
            $table->String('id_subject')->after('id_exam')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_examination_room_settings', function (Blueprint $table) {
            $table->uuid('id_organization')->foreign('id_organization')->references('id')->on('tbl_organization')->onDelete('cascade')->after('id');
            $table->uuid('id_institution')->foreign('id_institution')->references('id')->on('tbl_institution')->onDelete('cascade')->after('id');
            $table->String('id_standard')->after('id_exam')->nullable();
            $table->String('id_subject')->after('id_exam')->nullable();
        });
    }
};
