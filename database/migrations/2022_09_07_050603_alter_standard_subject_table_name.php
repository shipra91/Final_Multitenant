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
        
        Schema::table('tbl_standard_subject', function (Blueprint $table) {
            $table->uuid('id_academic_year')->foreign('id_academic_year')->references('id')->on('tbl_academic_year_mappings')->onDelete('cascade')->after('display_name');

            $table->uuid('id_institute')->foreign('id_institute')->references('id')->on('tbl_institution')->onDelete('cascade')->after('display_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_standard_subject', function (Blueprint $table) {
            $table->dropColumn('id_academic_year');
            $table->dropColumn('id_institute');
        });
    }
};
